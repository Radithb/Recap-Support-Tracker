<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\MasterKategori;

class FaqController extends Controller
{
    /**
     * CRUD: Simpan FAQ baru (Support)
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'  => 'required|exists:master_kategoris,kategori_id',
            'pertanyaan'   => 'required|string|max:500',
            'jawaban'      => 'required|string',
        ]);

        Faq::create([
            'kategori_id' => $request->kategori_id,
            'pertanyaan'  => $request->pertanyaan,
            'jawaban'     => $request->jawaban,
            'visibility'  => 'internal', // Default to internal since it's only for support now
            'is_active'   => true,
        ]);

        return back()->with('success', 'FAQ berhasil ditambahkan.');
    }

    /**
     * CRUD: Update FAQ (Support)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id'  => 'required|exists:master_kategoris,kategori_id',
            'pertanyaan'   => 'required|string|max:500',
            'jawaban'      => 'required|string',
            'is_active'    => 'required|boolean',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update([
            'kategori_id' => $request->kategori_id,
            'pertanyaan'  => $request->pertanyaan,
            'jawaban'     => $request->jawaban,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'FAQ berhasil diperbarui.');
    }

    /**
     * CRUD: Hapus FAQ (Support)
     */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return back()->with('success', 'FAQ berhasil dihapus.');
    }

    /**
     * API/JSON: Semua FAQ aktif (public + internal) untuk Support (insert to modal)
     */
    public function allForSupport(Request $request)
    {
        $query = Faq::with('kategori:kategori_id,nama_kategori')->active();

        // Opsional: filter by kategori_id
        if ($request->has('kategori_id') && $request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $faqs = $query->select('faq_id', 'kategori_id', 'pertanyaan', 'jawaban')
                      ->orderBy('kategori_id')
                      ->get();

        return response()->json($faqs);
    }
}
