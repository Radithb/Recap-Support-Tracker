<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImplementasiLog extends Model
{
    use HasFactory;

    protected $table = 'implementasi_logs';

    protected $fillable = [
        'implementasi_id',
        'user_id',
        'aktivitas',
        'data_sebelum',
        'data_sesudah',
        'catatan',
    ];

    protected $casts = [
        'data_sebelum' => 'array',
        'data_sesudah' => 'array',
    ];

    public function implementasi()
    {
        return $this->belongsTo(ImplementasiKoperasi::class, 'implementasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
