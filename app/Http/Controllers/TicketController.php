<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\MasterAplikasi;
use App\Models\MasterKategori;
use App\Enums\TicketStatus;
use App\Http\Requests\StoreTicketRequest;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // --- PELAPOR METHODS ---
    public function pelaporDashboard()
    {
        $tickets = Ticket::where('pelapor_id', Auth::id())->latest('tanggal_input')->take(5)->get();
        $aplikasis = MasterAplikasi::where('is_active', true)->get();
        
        $totalOpen = Ticket::where('pelapor_id', Auth::id())->whereIn('status', [\App\Enums\TicketStatus::OPEN, \App\Enums\TicketStatus::PROSES])->count();
        $totalPending = Ticket::where('pelapor_id', Auth::id())->where('status', \App\Enums\TicketStatus::PENDING)->count();
        $totalDone = Ticket::where('pelapor_id', Auth::id())->where('status', \App\Enums\TicketStatus::DONE)->count();

        return view('pelapor.dashboard', compact('tickets', 'aplikasis', 'totalOpen', 'totalPending', 'totalDone'));
    }

    public function pelaporRiwayat(Request $request)
    {
        $query = Ticket::where('pelapor_id', Auth::id());
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $tickets = $query->latest('tanggal_input')->get();
        $aplikasis = MasterAplikasi::where('is_active', true)->get();
        
        return view('pelapor.riwayat', compact('tickets', 'aplikasis'));
    }

    public function store(StoreTicketRequest $request)
    {
        $data = $request->validated();
        
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_tiket', 'public');
        }

        Ticket::create([
            'pelapor_id' => Auth::id(),
            'aplikasi_id' => $data['aplikasi_id'],
            'permasalahan' => $data['permasalahan'],
            'lampiran' => $lampiranPath,
            'status' => TicketStatus::OPEN->value,
        ]);

        return back()->with('success', __('messages.ticket_created'));
    }

    // --- SUPPORT METHODS ---
    public function supportDashboard(Request $request)
    {
        $query = Ticket::with(['pelapor.instansi', 'aplikasi', 'kategori']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_id', 'like', "%$search%")
                  ->orWhere('permasalahan', 'like', "%$search%");
            });
        }

        $tickets = $query->latest('tanggal_input')->paginate(10);
        $kategoris = MasterKategori::all();

        // Ambil daftar user pelapor yang belum diverifikasi
        $pendingUsers = \App\Models\User::with('instansi')
            ->where('role', \App\Enums\UserRole::PELAPOR->value)
            ->where('is_verified', false)
            ->latest()
            ->get();

        return view('support.dashboard', compact('tickets', 'kategoris', 'pendingUsers'));
    }

    public function updateSupport(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|string',
            'kategori_id' => 'required_if:status,Done',
            'penyelesaian' => 'required_if:status,Done|nullable|string',
            'pencegahan' => 'nullable|string',
            'link_ticket' => 'nullable|string',
            'is_faq' => 'nullable|boolean',
        ]);

        $data = $request->only(['status', 'kategori_id', 'penyelesaian', 'pencegahan', 'link_ticket']);
        $data['is_faq'] = $request->has('is_faq');
        
        if ($data['status'] === TicketStatus::DONE->value && $ticket->status !== TicketStatus::DONE) {
            $data['tanggal_penyelesaian'] = now();
            $data['pic_support_id'] = Auth::id(); // Assign current support user
        }

        $ticket->update($data);

        return back()->with('success', __('messages.ticket_updated'));
    }
}
