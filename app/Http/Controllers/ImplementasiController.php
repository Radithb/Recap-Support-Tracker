<?php

namespace App\Http\Controllers;

use App\Models\ImplementasiKoperasi;
use App\Models\ImplementasiChecklist;
use App\Models\ImplementasiLog;
use App\Models\Instansi;
use App\Models\MasterAplikasi;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImplementasiController extends Controller
{
    /**
     * Menampilkan data dashboard implementasi
     */
    public function index()
    {
        $query = ImplementasiKoperasi::with(['instansi', 'aplikasi', 'aplikasis', 'picSakti'])
            ->orderBy('created_at', 'desc');

        if (Auth::user()->role === UserRole::PELAPOR) {
            $query->where('instansi_id', Auth::user()->instansi_id);
        }

        $implementasis = $query->get();

        $instansis = Instansi::orderBy('nama_instansi')->get();
        $aplikasis = MasterAplikasi::where('is_active', true)->orderBy('nama_aplikasi')->get();
        $usersSupport = User::whereIn('role', [UserRole::SUPPORT, UserRole::SUPERADMIN])->orderBy('nama')->get();

        return view('implementasi.index', compact('implementasis', 'instansis', 'aplikasis', 'usersSupport'));
    }

    /**
     * Menampilkan halaman detail implementasi (Tabs UI)
     */
    public function show($id)
    {
        $implementasi = ImplementasiKoperasi::with([
            'instansi', 
            'aplikasi', 
            'aplikasis',
            'picSakti', 
            'checklists' => function($q) {
                $q->orderBy('kategori', 'asc')->orderBy('id', 'asc');
            }, 
            'logs'
        ])->findOrFail($id);

        // Security check for Pelapor
        if (Auth::user()->role === UserRole::PELAPOR && $implementasi->instansi_id !== Auth::user()->instansi_id) {
            abort(403, 'Anda tidak memiliki akses ke data implementasi ini.');
        }

        return view('implementasi.show', compact('implementasi'));
    }

    /**
     * Menyimpan data implementasi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'instansi_id' => 'required|exists:instansis,instansi_id',
            'aplikasi_id' => 'required|array',
            'aplikasi_id.*' => 'required|exists:master_aplikasis,aplikasi_id',
            'tanggal_pelatihan' => 'required|date',
            'metode_pelatihan' => 'required|string',
            'nama_trainer' => 'nullable|array',
            'nama_trainer.*' => 'nullable|string',
            'anggota_hadir' => 'required|array',
            'anggota_hadir.*' => 'required|string',
            'kontak_pic' => 'required|string',
            'email_pic' => 'nullable|email',
            'catatan_pelatihan' => 'nullable|string',
            'target_go_live' => 'nullable|date',
        ]);

        // Generate Nomor Implementasi: IMP/SAKTI/YYYY/001
        $year = date('Y');
        $lastImpl = ImplementasiKoperasi::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $nextNumber = $lastImpl ? intval(substr($lastImpl->nomor_implementasi, -3)) + 1 : 1;
        $nomor_implementasi = 'IMP/SAKTI/' . $year . '/' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $implementasi = ImplementasiKoperasi::create([
            'nomor_implementasi' => $nomor_implementasi,
            'instansi_id' => $request->instansi_id,
            'aplikasi_id' => is_array($request->aplikasi_id) ? $request->aplikasi_id[0] : $request->aplikasi_id, // Backward compatibility
            'tanggal_pelatihan' => $request->tanggal_pelatihan,
            'metode_pelatihan' => $request->metode_pelatihan,
            'nama_trainer' => is_array($request->nama_trainer) ? implode(', ', array_filter($request->nama_trainer)) : null,
            'anggota_hadir' => implode(', ', $request->anggota_hadir),
            'kontak_pic' => $request->kontak_pic,
            'email_pic' => $request->email_pic,
            'catatan_pelatihan' => $request->catatan_pelatihan,
            'target_go_live' => $request->target_go_live,
            'status' => 'Pelatihan Selesai',
            'tindakan_berikutnya' => 'Follow-Up Kesiapan Koperasi',
            'pic_tindakan' => is_array($request->anggota_hadir) ? implode(', ', $request->anggota_hadir) : ($request->anggota_hadir ?? 'Tim Support'),
        ]);

        // Sync pivot table
        if (is_array($request->aplikasi_id)) {
            $implementasi->aplikasis()->sync($request->aplikasi_id);
        }

        // Auto-generate checklists
        $defaultChecklists = [
            ['kategori' => 'Data Utama', 'nama_item' => 'Data anggota tersedia'],
            ['kategori' => 'Data Utama', 'nama_item' => 'Data user atau pengguna tersedia'],
            ['kategori' => 'Keuangan', 'nama_item' => 'Data simpanan tersedia'],
            ['kategori' => 'Keuangan', 'nama_item' => 'Data pinjaman tersedia'],
            ['kategori' => 'Keuangan', 'nama_item' => 'Data saldo awal tersedia'],
            ['kategori' => 'Keuangan', 'nama_item' => 'Data COA tersedia'],
            ['kategori' => 'Master', 'nama_item' => 'Data produk simpanan tersedia'],
            ['kategori' => 'Master', 'nama_item' => 'Data produk pinjaman tersedia'],
        ];

        foreach ($defaultChecklists as $chk) {
            ImplementasiChecklist::create([
                'implementasi_id' => $implementasi->id,
                'kategori' => $chk['kategori'],
                'nama_item' => $chk['nama_item'],
            ]);
        }

        ImplementasiLog::create([
            'implementasi_id' => $implementasi->id,
            'user_id' => Auth::id(),
            'aktivitas' => 'Data Implementasi Dibuat',
            'catatan' => 'Pelatihan selesai, lanjut ke follow up kesiapan.'
        ]);

        return redirect()->route('implementasi.index')->with('success', 'Data Implementasi berhasil ditambahkan.');
    }

    /**
     * Method AJAX untuk update checklist dan catat log
     */
    public function updateChecklist(Request $request, $id)
    {
        if (Auth::user()->role === UserRole::PELAPOR) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $request->validate([
            'status' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $checklist = ImplementasiChecklist::findOrFail($id);
        
        $oldStatus = $checklist->status;
        $oldCatatan = $checklist->catatan;

        $checklist->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        $implementasi = $checklist->implementasi;

        // Mencatat log aktivitas
        ImplementasiLog::create([
            'implementasi_id' => $implementasi->id,
            'user_id' => Auth::id(),
            'aktivitas' => 'Update Checklist: ' . $checklist->nama_item,
            'data_sebelum' => ['status' => $oldStatus, 'catatan' => $oldCatatan],
            'data_sesudah' => ['status' => $checklist->status, 'catatan' => $checklist->catatan],
            'catatan' => 'Checklist diperbarui via AJAX'
        ]);

        // Hitung ulang progres
        $newProgres = $implementasi->updateProgres();

        return response()->json([
            'success' => true,
            'message' => 'Checklist berhasil diperbarui',
            'new_progres' => $newProgres,
            'checklist' => $checklist
        ]);
    }

    /**
     * Menampilkan form edit implementasi
     */
    public function edit($id)
    {
        $implementasi = ImplementasiKoperasi::with(['aplikasis'])->findOrFail($id);
        
        // Security check for Pelapor
        if (Auth::user()->role === UserRole::PELAPOR && $implementasi->instansi_id !== Auth::user()->instansi_id) {
            abort(403, 'Anda tidak memiliki akses ke data implementasi ini.');
        }

        $instansis = Instansi::orderBy('nama_instansi')->get();
        $aplikasis = MasterAplikasi::where('is_active', true)->orderBy('nama_aplikasi')->get();

        return view('implementasi.edit', compact('implementasi', 'instansis', 'aplikasis'));
    }

    /**
     * Menyimpan pembaruan data implementasi
     */
    public function update(Request $request, $id)
    {
        $implementasi = ImplementasiKoperasi::findOrFail($id);

        if (Auth::user()->role === UserRole::PELAPOR) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data ini.');
        }

        $request->validate([
            'instansi_id' => 'required|exists:instansis,instansi_id',
            'aplikasi_id' => 'required|array',
            'aplikasi_id.*' => 'required|exists:master_aplikasis,aplikasi_id',
            'tanggal_pelatihan' => 'required|date',
            'metode_pelatihan' => 'required|string',
            'nama_trainer' => 'nullable|array',
            'nama_trainer.*' => 'nullable|string',
            'anggota_hadir' => 'required|array',
            'anggota_hadir.*' => 'required|string',
            'kontak_pic' => 'required|string',
            'email_pic' => 'nullable|email',
            'catatan_pelatihan' => 'nullable|string',
            'target_go_live' => 'nullable|date',
        ]);

        $implementasi->update([
            'instansi_id' => $request->instansi_id,
            'aplikasi_id' => is_array($request->aplikasi_id) ? $request->aplikasi_id[0] : $request->aplikasi_id, // Backward compatibility
            'tanggal_pelatihan' => $request->tanggal_pelatihan,
            'metode_pelatihan' => $request->metode_pelatihan,
            'nama_trainer' => is_array($request->nama_trainer) ? implode(', ', array_filter($request->nama_trainer)) : null,
            'anggota_hadir' => implode(', ', $request->anggota_hadir),
            'kontak_pic' => $request->kontak_pic,
            'email_pic' => $request->email_pic,
            'catatan_pelatihan' => $request->catatan_pelatihan,
            'target_go_live' => $request->target_go_live,
            'pic_tindakan' => is_array($request->anggota_hadir) ? implode(', ', $request->anggota_hadir) : ($request->anggota_hadir ?? 'Tim Support'),
        ]);

        // Sync pivot table
        if (is_array($request->aplikasi_id)) {
            $implementasi->aplikasis()->sync($request->aplikasi_id);
        }

        ImplementasiLog::create([
            'implementasi_id' => $implementasi->id,
            'user_id' => Auth::id(),
            'aktivitas' => 'Data Implementasi Diperbarui',
            'catatan' => 'Data implementasi diperbarui melalui form edit.'
        ]);

        return redirect()->route('implementasi.index')->with('success', 'Data Implementasi berhasil diperbarui.');
    }

    /**
     * Menghapus data implementasi
     */
    public function destroy($id)
    {
        if (Auth::user()->role === UserRole::PELAPOR) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data ini.');
        }

        $implementasi = ImplementasiKoperasi::findOrFail($id);
        
        // Hapus relasi pivot aplikasi jika ada
        $implementasi->aplikasis()->detach();
        
        // Hapus data (relasi checklist dan log otomatis terhapus karena foreign key onDelete cascade)
        $implementasi->delete();

        return redirect()->route('implementasi.index')->with('success', 'Data Implementasi berhasil dihapus.');
    }
}
