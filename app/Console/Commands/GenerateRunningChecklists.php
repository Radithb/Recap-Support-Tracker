<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ImplementasiKoperasi;

class GenerateRunningChecklists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recap:generate-running';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Men-generate checklist Running Monitoring untuk data implementasi lama yang belum memilikinya';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan dan generate Running Monitoring checklist...');

        $implementasis = ImplementasiKoperasi::all();
        $runningItems = [
            ['kategori' => 'Running - Penggunaan Aplikasi', 'nama_item' => 'SAS sudah digunakan sebagai aplikasi operasional utama'],
            ['kategori' => 'Running - Penggunaan Aplikasi', 'nama_item' => 'Operator aktif menggunakan SAS'],
            ['kategori' => 'Running - Penggunaan Aplikasi', 'nama_item' => 'Proses manual/Excel untuk transaksi utama sudah ditinggalkan'],
            ['kategori' => 'Running - Transaksi', 'nama_item' => 'Transaksi anggota sudah berjalan'],
            ['kategori' => 'Running - Transaksi', 'nama_item' => 'Transaksi simpanan sudah berjalan'],
            ['kategori' => 'Running - Transaksi', 'nama_item' => 'Transaksi pinjaman sudah berjalan'],
            ['kategori' => 'Running - Transaksi', 'nama_item' => 'Transaksi angsuran sudah berjalan'],
            ['kategori' => 'Running - Transaksi', 'nama_item' => 'Transaksi kas sudah berjalan'],
            ['kategori' => 'Running - Laporan', 'nama_item' => 'Laporan sudah digunakan oleh koperasi'],
            ['kategori' => 'Running - Laporan', 'nama_item' => 'Laporan SAS menjadi acuan operasional'],
            ['kategori' => 'Running - Kemandirian', 'nama_item' => 'Operator dapat melakukan transaksi tanpa bantuan Support'],
            ['kategori' => 'Running - Kemandirian', 'nama_item' => 'Operator dapat melakukan pengecekan/koreksi sederhana sendiri'],
            ['kategori' => 'Running - Kemandirian', 'nama_item' => 'Operator sudah memahami proses operasional SAS']
        ];
        
        $count = 0;
        foreach($implementasis as $impl) {
            // Check if it already has running items
            $hasRunning = $impl->checklists()->where('kategori', 'like', 'Running%')->exists();
            if (!$hasRunning) {
                foreach($runningItems as $item) {
                    $impl->checklists()->create([
                        'kategori' => $item['kategori'],
                        'nama_item' => $item['nama_item'],
                        'status' => 'Belum Dikirim',
                    ]);
                }
                $count++;
            }
        }

        $this->info("Selesai! Checklist berhasil ditambahkan untuk {$count} data implementasi.");
    }
}
