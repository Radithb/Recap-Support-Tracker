<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterAplikasi;
use App\Models\MasterKategori;
use App\Models\Instansi;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\TicketStatus;

class MasterDataController extends Controller
{
    public function index()
    {
        $aplikasis = MasterAplikasi::all();
        $kategoris = MasterKategori::all();
        $instansis = Instansi::withCount('users')->get();
        $supportPics = User::where('role', UserRole::SUPPORT)->get();
        $statuses = TicketStatus::cases();

        return view('support.master-data', compact('aplikasis', 'kategoris', 'instansis', 'supportPics', 'statuses'));
    }
    
    public function storeAplikasi(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        MasterAplikasi::create([
            'nama_aplikasi' => $request->nama_aplikasi,
            'deskripsi' => $request->deskripsi,
            'is_active' => true
        ]);

        return back()->with('success', __('messages.app_added'));
    }

    public function updateAplikasi(Request $request, $id)
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $aplikasi = MasterAplikasi::findOrFail($id);
        $aplikasi->update([
            'nama_aplikasi' => $request->nama_aplikasi,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Aplikasi berhasil diperbarui.');
    }

    public function destroyAplikasi($id)
    {
        $aplikasi = MasterAplikasi::findOrFail($id);

        if ($aplikasi->tickets()->count() > 0) {
            return back()->with('error', __('messages.app_cannot_delete_has_tickets'));
        }

        $aplikasi->delete();

        return back()->with('success', __('messages.app_deleted'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        MasterKategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return back()->with('success', __('messages.cat_added'));
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        $kategori = MasterKategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyKategori($id)
    {
        $kategori = MasterKategori::findOrFail($id);

        if ($kategori->tickets()->count() > 0) {
            return back()->with('error', __('messages.cat_cannot_delete_has_tickets'));
        }

        $kategori->delete();

        return back()->with('success', __('messages.cat_deleted'));
    }

    public function export()
    {
        $aplikasis = MasterAplikasi::all();
        $kategoris = MasterKategori::all();
        $instansis = Instansi::all();
        $supportPics = User::where('role', UserRole::SUPPORT)->get();
        $statuses = TicketStatus::cases();

        $maxRows = max(
            count($aplikasis),
            count($kategoris),
            count($instansis),
            count($supportPics),
            count($statuses)
        );

        $headerStyle = 'bgcolor="#e2e8f0" color="#0f172a" border="thin#475569"';
        $cellStyle   = 'border="thin#64748b"';

        $data = [
            [
                "<style {$headerStyle}><b>Nama Koperasi</b></style>",
                "<style {$headerStyle}><b>Jenis Case</b></style>",
                "<style {$headerStyle}><b>Jenis Aplikasi</b></style>",
                "<style {$headerStyle}><b>PIC TIM SUPPORT</b></style>",
                "<style {$headerStyle}><b>Status</b></style>",
            ]
        ];

        for ($i = 0; $i < $maxRows; $i++) {
            $val1 = isset($instansis[$i]) ? $instansis[$i]->nama_instansi : '';
            $val2 = isset($kategoris[$i]) ? $kategoris[$i]->nama_kategori : '';
            $val3 = isset($aplikasis[$i]) ? $aplikasis[$i]->nama_aplikasi : '';
            $val4 = isset($supportPics[$i]) ? $supportPics[$i]->nama : '';
            $val5 = isset($statuses[$i]) ? $statuses[$i]->value : '';

            $data[] = [
                "<style {$cellStyle}>" . htmlspecialchars($val1) . "</style>",
                "<style {$cellStyle}>" . htmlspecialchars($val2) . "</style>",
                "<style {$cellStyle}>" . htmlspecialchars($val3) . "</style>",
                "<style {$cellStyle}>" . htmlspecialchars($val4) . "</style>",
                "<style {$cellStyle}>" . htmlspecialchars($val5) . "</style>",
            ];
        }

        $filename = "Master_Data_Export_" . date('Ymd_His') . ".xlsx";
        $xlsx = \App\Helpers\SimpleXLSXGen::fromArray($data);

        return response((string) $xlsx)->withHeaders([
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
