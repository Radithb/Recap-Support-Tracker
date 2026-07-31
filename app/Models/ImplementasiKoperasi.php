<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImplementasiKoperasi extends Model
{
    use HasFactory;

    protected $table = 'implementasi_koperasi';

    protected $fillable = [
        'nomor_implementasi',
        'instansi_id',
        'aplikasi_id',
        'tanggal_pelatihan',
        'tanggal_selesai',
        'metode_pelatihan',
        'berita_acara',
        'nama_trainer',
        'pic_sakti_id',
        'anggota_hadir',
        'pic_koperasi',
        'kontak_pic',
        'email_pic',
        'catatan_pelatihan',
        'target_go_live',
        'waktu_go_live',
        'tempat_go_live',
        'status_go_live',
        'metode_pendampingan',
        'link_meeting',
        'catatan_kesiapan',
        'potensi_risiko',
        'rencana_mitigasi',
        'tanggal_cut_off',
        'status',
        'progres',
        'tindakan_berikutnya',
        'pic_tindakan',
        'target_tanggal_tindakan',
        'status_tindakan',
    ];

    protected $casts = [
        'tanggal_pelatihan' => 'date',
        'tanggal_selesai' => 'date',
        'target_go_live' => 'date',
        'tanggal_cut_off' => 'date',
        'target_tanggal_tindakan' => 'date',
        'progres' => 'decimal:2',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id', 'instansi_id');
    }

    public function aplikasi()
    {
        return $this->belongsTo(MasterAplikasi::class, 'aplikasi_id', 'aplikasi_id');
    }

    public function aplikasis()
    {
        return $this->belongsToMany(MasterAplikasi::class, 'aplikasi_implementasi', 'implementasi_id', 'aplikasi_id');
    }

    public function picSakti()
    {
        return $this->belongsTo(User::class, 'pic_sakti_id', 'user_id');
    }

    public function checklists()
    {
        return $this->hasMany(ImplementasiChecklist::class, 'implementasi_id');
    }

    public function logs()
    {
        return $this->hasMany(ImplementasiLog::class, 'implementasi_id')->orderBy('created_at', 'desc');
    }

    /**
     * Menghitung persentase progres secara otomatis berdasarkan jumlah checklist
     * yang berstatus 'Sudah Valid' lalu mengupdate kolom progres.
     */
    public function updateProgres()
    {
        $query = $this->checklists()->where('kategori', '!=', 'Migrasi');
        $totalChecklist = $query->count();

        if ($totalChecklist == 0) {
            $this->update(['progres' => 0]);
            return 0;
        }

        $validChecklist = (clone $query)->whereIn('status', ['Sudah Valid', 'Selesai', 'Done'])->count();
        $persentase = ($validChecklist / $totalChecklist) * 100;

        $this->update(['progres' => round($persentase, 2)]);

        return round($persentase, 2);
    }
    public function checkAndSetGoLiveDate()
    {
        if ($this->target_go_live !== null) {
            return;
        }

        $allDone = ['Sudah Valid', 'Done', 'Selesai'];

        // 1. Data utama sudah tersedia (Kategori: Data Utama) & 6. User aplikasi (Kategori: Data Utama)
        $dataUtamaNotDone = $this->checklists()->where('kategori', 'Data Utama')->whereNotIn('status', $allDone)->count();

        // 2. Data cut-off sudah disepakati
        $cutOffSet = !empty($this->tanggal_cut_off);

        // 3. Migrasi selesai
        $migrasiNotDone = $this->checklists()->where('kategori', 'Migrasi')->whereNotIn('status', $allDone)->count();

        // 4. Koperasi sudah siap menjalankan transaksi (catatan_kesiapan terisi)
        $ready = !empty($this->catatan_kesiapan);

        // 5. PIC koperasi telah ditentukan (anggota_hadir atau pic_koperasi terisi)
        $picSet = !empty($this->anggota_hadir) || !empty($this->pic_koperasi);

        // 6. Jadwal pendampingan telah disiapkan (metode_pendampingan terisi)
        $jadwalSet = !empty($this->metode_pendampingan);

        if ($dataUtamaNotDone === 0 && $cutOffSet && $migrasiNotDone === 0 && $ready && $picSet && $jadwalSet) {
            $this->target_go_live = \Carbon\Carbon::today();
            $this->save();

            \App\Models\ImplementasiLog::create([
                'implementasi_id' => $this->id,
                'user_id' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                'aktivitas' => 'Otomatis Set Tanggal Go-Live',
                'catatan' => 'Semua prasyarat telah terpenuhi, tanggal Go-Live otomatis diisi dengan tanggal hari ini.'
            ]);
        }
    }
}
