<?php

namespace App\Http\Controllers;

use App\Collector;
use App\Donation;
use App\Mustahiq;
use Illuminate\Http\Request;

class CollectorDonationReportPrintController extends Controller
{
    const ROW_PER_PAGE = 8;

    public function show(Request $request, Collector $collector)
    {
        $data = $request->validate([
            "year" => "required|integer|gte:0"
        ]);

        $donations = Donation::query()
            ->with("mustahiq")
            ->orderBy(
                Mustahiq::query()
                    ->whereColumn("donations.mustahiq_id", "mustahiqs.id")
                    ->select("name")
                    ->limit(1)
            )
            ->where("collector_id", $collector->id ?? null)
            ->whereYear("transaction_date", $data["year"])
            ->get();

        return view("collector_donation_report_print/show", [
            "collector" => $collector,
            "donations" => $donations,
            "year" => $data["year"],
            "row_per_page" => static::ROW_PER_PAGE,
        ]);
    }
}
