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

        return view('support.recap', compact('year', 'chartData', 'crosstab'));
    }
}
