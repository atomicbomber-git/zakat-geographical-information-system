<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $current_year = request('year') ?? now()->format('Y');

        $reports = Report::query()
            ->select('transaction_date', 'zakat', 'fitrah', 'infak', 'note', 'collector_id')
            ->whereRaw('YEAR(transaction_date) = ?', [$current_year])
            ->with('collector')
            ->get();

        $years = Report::query()
            ->select(DB::raw('YEAR(transaction_date) AS year'))
            ->orderBy('transaction_date', 'DESC')
            ->groupBy(DB::raw('YEAR(transaction_date)'))
            ->pluck('year');

        return view('report.index', compact('reports', 'current_year', 'years'));
    }
}
