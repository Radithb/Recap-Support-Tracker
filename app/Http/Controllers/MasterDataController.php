<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterAplikasi;
use App\Models\MasterKategori;

class MasterDataController extends Controller
{
    public function index()
    {
        $aplikasis = MasterAplikasi::all();
        $kategoris = MasterKategori::all();
        return view('support.master-data', compact('aplikasis', 'kategoris'));
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
}
