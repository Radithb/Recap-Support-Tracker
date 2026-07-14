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
    
    // Create, Update, Delete logic would be here for CRUD Master Data.
}
