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
        'metode_pelatihan',
        'nama_trainer',
        'pic_sakti_id',
        'pic_koperasi',
        'kontak_pic',
        'email_pic',
        'catatan_pelatihan',
        'target_go_live',
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
        $totalChecklist = $this->checklists()->count();

        if ($totalChecklist == 0) {
            $this->update(['progres' => 0]);
            return 0;
        }

        $validChecklist = $this->checklists()->where('status', 'Sudah Valid')->count();
        $persentase = ($validChecklist / $totalChecklist) * 100;

        $this->update(['progres' => round($persentase, 2)]);

        return round($persentase, 2);
    }
}
