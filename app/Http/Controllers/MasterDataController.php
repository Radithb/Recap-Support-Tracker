<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterAplikasi;
use App\Models\MasterKategori;
use App\Models\Instansi;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\TicketStatus;

class MasterDataController extends Controller
{
    public function index()
    {
        $aplikasis = MasterAplikasi::all();
        $kategoris = MasterKategori::all();
        $instansis = Instansi::withCount('users')->get();
        $supportPics = User::where('role', UserRole::SUPPORT)->get();
        $statuses = TicketStatus::cases();

        return view('support.master-data', compact('aplikasis', 'kategoris', 'instansis', 'supportPics', 'statuses'));
    }
    
    public function storeAplikasi(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        MasterAplikasi::create([
            'nama_aplikasi' => $request->nama_aplikasi,
            'deskripsi' => $request->deskripsi,
            'is_active' => true
        ]);

        return back()->with('success', __('messages.app_added'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        MasterKategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return back()->with('success', __('messages.cat_added'));
    }

    public function export()
    {
        $aplikasis = MasterAplikasi::all();
        $kategoris = MasterKategori::all();
        $instansis = Instansi::all();
        $supportPics = User::where('role', UserRole::SUPPORT)->get();
        $statuses = TicketStatus::cases();

        $maxRows = max(
            count($aplikasis),
            count($kategoris),
            count($instansis),
            count($supportPics),
            count($statuses)
        );

        $filename = "Master_Data_Export_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama Koperasi', 'Jenis Case', 'Jenis Aplikasi', 'PIC TIM SUPPORT', 'Status'];

        $callback = function() use($aplikasis, $kategoris, $instansis, $supportPics, $statuses, $columns, $maxRows) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 compatibility
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns, ';');

            for ($i = 0; $i < $maxRows; $i++) {
                $row = [
                    isset($instansis[$i]) ? $instansis[$i]->nama_instansi : '',
                    isset($kategoris[$i]) ? $kategoris[$i]->nama_kategori : '',
                    isset($aplikasis[$i]) ? $aplikasis[$i]->nama_aplikasi : '',
                    isset($supportPics[$i]) ? $supportPics[$i]->nama : '',
                    isset($statuses[$i]) ? $statuses[$i]->value : ''
                ];
                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
