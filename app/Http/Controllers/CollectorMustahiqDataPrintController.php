<?php

namespace App\Http\Controllers;

use App\Collector;
use App\Mustahiq;

class CollectorMustahiqDataPrintController extends Controller
{
    const ROW_PER_PAGE = 24;

    public function show(Collector $collector)
    {
        $mustahiqs = Mustahiq::query()
            ->select(
                "name",
                "address",
                "kecamatan",
                "kelurahan",
            )
            ->where("collector_id", $collector->id)
            ->withDonationsLastTransactionDate()
            ->withDonationsAmountSum()
            ->orderBy("name")
            ->get();

        return view("collector_mustahiq_data_print.show", [
            "collector" => $collector,
            "mustahiqs" => $mustahiqs,
            "rowPerPage" => static::ROW_PER_PAGE,
        ]);
    }
}
