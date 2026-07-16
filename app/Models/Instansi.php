<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $primaryKey = 'instansi_id';

    protected $fillable = [
        'nama_instansi',
        'alamat',
        'no_telp',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'instansi_id', 'instansi_id');
    }

    public function aplikasis()
    {
        return $this->belongsToMany(MasterAplikasi::class, 'instansi_aplikasi', 'instansi_id', 'aplikasi_id');
    }
}
