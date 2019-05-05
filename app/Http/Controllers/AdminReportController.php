<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Illuminate\Support\Facades\DB;
use App\Collector;
use Illuminate\Support\Carbon;

class AdminReportController extends Controller
{
    public function index()
    {
        $available_years = $this->getReportAvailableYears();
        $year = request('year') ?? $available_years->first();

        $collectors = Collector::query()
            ->select("id", "name")
            ->with(["report_total_amount" => function ($query) use($year) {
                $query->whereYear("transaction_date", $year);
            }])
            ->get();

        $yearly_reports = Report::query()
            ->select(DB::raw('SUM(zakat + fitrah + infak) AS amount'), DB::raw('YEAR(transaction_date) AS year'))
            ->groupBy('year')
            ->get()
            ->makeHidden('total');

        return view("admin_report.index", compact("collectors", "year", "available_years", "yearly_reports"));
    }

    public function printIndex()
    {
        $year = request('year') ?? Carbon::today()->format("Y");
        $collectors = Collector::query()
            ->select("id", "name")
            ->with(["report_total_amount" => function ($query) use($year) {
                $query->whereYear("transaction_date", $year);
            }])
            ->get();

        return view("admin_report.print_index", compact("year", "collectors"));
    }

    public function detail(Collector $collector)
    {
        $year = request('year') ?? Carbon::today()->format("Y");

        $collector->load(["reports" => function ($query) use ($year) {
            $query->select("id", "collector_id", "transaction_date", "zakat", "fitrah", "infak")
                ->whereYear("transaction_date", $year);
        }]);

        $yearly_reports = Report::query()
            ->select(DB::raw('SUM(zakat + fitrah + infak) AS amount'), DB::raw('YEAR(transaction_date) AS year'))
            ->groupBy('year')
            ->where('collector_id', $collector->id)
            ->get()
            ->makeHidden('total');

        return view("admin_report.detail", compact("collector", "year", "yearly_reports"));
    }

    private function getReportAvailableYears()
    {
        return Report::query()
            ->select(DB::raw('YEAR(transaction_date) AS year'))
            ->orderByDesc('year')
            ->groupBy('year')
            ->get()
            ->pluck('year');
    }
}
