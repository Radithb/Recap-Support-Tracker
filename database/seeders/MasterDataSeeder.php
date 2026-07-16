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
            ['nama_aplikasi' => 'SiCUNDO SAKTI', 'deskripsi' => 'Aplikasi SiCUNDO SAKTI', 'is_active' => true],
            ['nama_aplikasi' => 'SAKTI Multiusaha', 'deskripsi' => 'Aplikasi SAKTI Multiusaha', 'is_active' => true],
            ['nama_aplikasi' => 'LACI', 'deskripsi' => 'Aplikasi LACI', 'is_active' => true],
            ['nama_aplikasi' => 'Transaksi SAKTI.Link', 'deskripsi' => 'Aplikasi Transaksi SAKTI.Link', 'is_active' => true],
            ['nama_aplikasi' => 'SAKTI.Link', 'deskripsi' => 'Aplikasi SAKTI.Link', 'is_active' => true],
            ['nama_aplikasi' => 'SAKTI Retail', 'deskripsi' => 'Aplikasi SAKTI Retail', 'is_active' => true],
            ['nama_aplikasi' => 'SiCUNDO KU', 'deskripsi' => 'Aplikasi SiCUNDO KU', 'is_active' => true],
            ['nama_aplikasi' => 'Sakti Mobile', 'deskripsi' => 'Aplikasi Sakti Mobile', 'is_active' => true],
        ]);

        MasterKategori::insert([
            ['nama_kategori' => 'Migrasi Data'],
            ['nama_kategori' => 'Support SOP'],
            ['nama_kategori' => 'Support Data'],
            ['nama_kategori' => 'Support Teknis Bug/Optimise'],
            ['nama_kategori' => 'Transaksi SAKTI.Link'],
            ['nama_kategori' => 'Support Pra'],
            ['nama_kategori' => 'Setup Datalama'],
            ['nama_kategori' => 'Fraud'],
        ]);
    }
}
