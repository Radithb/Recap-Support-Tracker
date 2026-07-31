<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\MasterKategori;
use App\Enums\TicketStatus;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('support.recap.diagram', $request->query());
    }

    public function diagram(Request $request)
    {
        $year = $request->input('year', date('Y'));

        // FR-10A: Monthly Bar Chart Data (Grouping by month based on tanggal_input)
        $monthlyTickets = Ticket::select(
            DB::raw('MONTH(tanggal_input) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('tanggal_input', $year)
        ->groupBy('month')
        ->pluck('total', 'month')->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyTickets[$i] ?? 0;
        }

        return view('support.recap-diagram', compact('year', 'chartData'));
    }

    public function table(Request $request)
    {
        $year = $request->input('year', date('Y'));

        // FR-10B: Category Crosstab (Done tickets based on tanggal_penyelesaian)
        $kategoris = MasterKategori::all();
        
        $crosstabData = Ticket::select(
            'kategori_id',
            DB::raw('MONTH(tanggal_penyelesaian) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->where('status', TicketStatus::DONE->value)
        ->whereYear('tanggal_penyelesaian', $year)
        ->whereNotNull('kategori_id')
        ->groupBy('kategori_id', 'month')
        ->get();

        $crosstab = [];
        foreach ($kategoris as $kat) {
            $crosstab[$kat->kategori_id] = [
                'nama' => $kat->nama_kategori,
                'months' => array_fill(1, 12, 0),
                'total_year' => 0
            ];
        }

        foreach ($crosstabData as $data) {
            if (isset($crosstab[$data->kategori_id])) {
                $crosstab[$data->kategori_id]['months'][$data->month] = $data->total;
                $crosstab[$data->kategori_id]['total_year'] += $data->total;
            }
        }

        return view('support.recap-table', compact('year', 'crosstab'));
    }

    public function detail(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('n'));

        // Ambil tiket berdasarkan tanggal_input pada bulan dan tahun terpilih
        $tickets = Ticket::with(['pelapor.instansi', 'kategori', 'picSupport'])
            ->whereYear('tanggal_input', $year)
            ->whereMonth('tanggal_input', $month)
            ->orderBy('tanggal_input', 'asc')
            ->get();

        $monthName = __('messages.month_' . (int)$month);

        return view('support.recap-detail', compact('tickets', 'year', 'month', 'monthName'));
    }

    public function historyPic(Request $request)
    {
        $query = Ticket::with(['pelapor.instansi', 'kategori', 'picSupport', 'logs.user'])
            ->whereNotNull('pic_support_id');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_id', 'like', "%{$search}%")
                  ->orWhere('permasalahan', 'like', "%{$search}%")
                  ->orWhereHas('pelapor.instansi', function($iq) use ($search) {
                      $iq->where('nama_instansi', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('pic_id')) {
            $query->where('pic_support_id', $request->pic_id);
        }

        $tickets = $query->orderBy('updated_at', 'desc')->paginate(15)->appends($request->all());

        $supportUsers = \App\Models\User::whereIn('role', [\App\Enums\UserRole::SUPPORT->value, \App\Enums\UserRole::SUPERADMIN->value])->get();

        return view('support.recap-history-pic', compact('tickets', 'supportUsers'));
    }

    public function templateSurat(Request $request)
    {
        // Kerangka sementara, data kosong
        return view('support.recap-template-surat');
    }
}
