<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCutoffDetailsToImplementasiKoperasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('implementasi_koperasi', function (Blueprint $table) {
            $table->string('periode_transaksi_terakhir')->nullable();
            $table->string('saldo_terakhir')->nullable();
            $table->date('tanggal_tutup_buku')->nullable();
            $table->date('tanggal_mulai_aplikasi')->nullable();
            $table->string('pic_validasi')->nullable();
            $table->text('catatan_cutoff')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('implementasi_koperasi', function (Blueprint $table) {
            $table->dropColumn([
                'periode_transaksi_terakhir',
                'saldo_terakhir',
                'tanggal_tutup_buku',
                'tanggal_mulai_aplikasi',
                'pic_validasi',
                'catatan_cutoff'
            ]);
        });
    }
}
