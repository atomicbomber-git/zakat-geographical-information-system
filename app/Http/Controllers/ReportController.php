<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $available_years = $this->getReportAvailableYears();
        $year = request('year') ?? $available_years->first();

        $reports = Report::query()
            ->where("collector_id", Auth::user()->collector->id)
            ->whereYear("transaction_date", $year)
            ->orderByDesc("transaction_date")
            ->get();

        $yearly_reports = Report::query()
            ->select(DB::raw('SUM(zakat + fitrah + infak) AS amount'), DB::raw('YEAR(transaction_date) AS year'))
            ->where('collector_id', auth()->user()->collector->id)
            ->groupBy('year')
            ->get();

        return view("report.index", compact("year", "available_years", "reports", "yearly_reports"));
    }

    public function create()
    {
        return view("report.create", compact("report.create"));
    }

    public function store()
    {
        $data = $this->validate(request(), [
            'transaction_date' => 'required|date',
            'zakat' => 'required|numeric|gte:0',
            'fitrah' => 'required|numeric|gte:0',
            'infak' => 'required|numeric|gte:0',
        ]);

        Report::create(array_merge($data, [
            "collector_id" => Auth::user()->collector->id,
        ]));
        
        return redirect()
            ->route('report.index')
            ->with('message-success', __('messages.create.success'));
    }

    public function edit(Report $report)
    {
        return view("report.edit", compact("report"));
    }

    public function update(Report $report)
    {
        $data = $this->validate(request(), [
            'transaction_date' => 'required|date',
            'zakat' => 'required|numeric|gte:0',
            'fitrah' => 'required|numeric|gte:0',
            'infak' => 'required|numeric|gte:0',
        ]);

        $report->update($data);
        
        return redirect()
            ->route('report.index')
            ->with('message-success', __('messages.update.success'));
    }

    private function getReportAvailableYears()
    {
        return Report::query()
            ->select(DB::raw('YEAR(transaction_date) AS year'))
            ->where('collector_id', auth()->user()->collector->id)
            ->orderByDesc('year')
            ->groupBy('year')
            ->get()
            ->pluck('year');
    }
}
