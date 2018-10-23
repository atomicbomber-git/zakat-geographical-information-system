<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::select('transaction_date', 'zakat', 'fitrah', 'infak', 'note', 'collector_id')
            ->with('collector')
            ->get();

        return view('report.index', compact('reports'));
    }
}
