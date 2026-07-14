<?php

namespace Database\Seeders;

use App\Models\Instansi;
use App\Models\MasterAplikasi;
use App\Models\MasterKategori;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $instansi = Instansi::create([
            'nama_instansi' => 'Koperasi Kredit Sejahtera',
            'alamat' => 'Jl. Merdeka No. 1, Jakarta',
            'no_telp' => '021-12345678',
        ]);

        MasterAplikasi::insert([
            ['nama_aplikasi' => 'SAKTI.Link', 'deskripsi' => 'Aplikasi SAKTI Link', 'is_active' => true],
            ['nama_aplikasi' => 'SiCUNDO', 'deskripsi' => 'Aplikasi SiCUNDO', 'is_active' => true],
            ['nama_aplikasi' => 'SAKTI Online', 'deskripsi' => 'Aplikasi SAKTI Online', 'is_active' => true],
        ]);

        MasterKategori::insert([
            ['nama_kategori' => 'Bug / Error'],
            ['nama_kategori' => 'Kesalahan Data'],
            ['nama_kategori' => 'Kendala SOP'],
            ['nama_kategori' => 'Permintaan Fitur'],
        ]);
    }
}
