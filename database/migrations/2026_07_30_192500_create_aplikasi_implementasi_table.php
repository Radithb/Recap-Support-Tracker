<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('aplikasi_implementasi');
        Schema::create('aplikasi_implementasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('implementasi_id')->constrained('implementasi_koperasi')->onDelete('cascade');
            $table->foreignId('aplikasi_id')->constrained('master_aplikasis')->onDelete('cascade');
            $table->timestamps();
        });

        // Hapus foreign key lama dari implementasi_koperasi (jika ada) dan bolehkan null
        Schema::table('implementasi_koperasi', function (Blueprint $table) {
            // $table->dropForeign(['aplikasi_id']); // Kita skip ini dulu karena di infinityfree sering masalah. Biarkan kolom lama tetap ada tapi nullable
            $table->unsignedBigInteger('aplikasi_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aplikasi_implementasi');
    }
};
