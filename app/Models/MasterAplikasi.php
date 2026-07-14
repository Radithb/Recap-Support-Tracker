<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterAplikasi extends Model
{
    protected $table = 'master_aplikasis';
    protected $primaryKey = 'aplikasi_id';

    protected $fillable = [
        'nama_aplikasi',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'aplikasi_id', 'aplikasi_id');
    }
}
