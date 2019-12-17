<?php

namespace App\Http\Controllers;

use App\Collector;
use App\Muzakki;
use App\Receivement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CollectorReceivementReportPrintController extends Controller
{
    const ROW_PER_PAGE = 8;

    public function show(Request $request)
    {
        $data = $request->validate([
            "year" => "required|integer|gte:0"
        ]);

        $collector = $request->user()->collector;

        $receivements = Receivement::query()
            ->with("muzakki")
            ->orderBy(
                Muzakki::query()
                    ->whereColumn("receivements.muzakki_id", "muzakkis.id")
                    ->select("name")
                    ->limit(1)
            )
            ->where("collector_id", $collector->id ?? null)
            ->whereYear("transaction_date", $data["year"])
            ->get();

        return view("collector_receivement_report_print.show", [
            "collector" => $collector,
            "receivements" => $receivements,
            "year" => $data["year"],
            "row_per_page" => static::ROW_PER_PAGE,
        ]);
    }
}
