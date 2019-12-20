<?php

namespace App\Http\Controllers;

use App\Collector;
use App\Muzakki;

class CollectorMuzakkiDataPrintController extends Controller
{
    const ROW_PER_PAGE = 24;

    public function show(Collector $collector)
    {
        $muzakkis = Muzakki::query()
            ->where("collector_id", $collector->id)
            ->withReceivementLastTransactionDate()
            ->withReceivementAmountSum()
            ->orderBy("name")
            ->get();

        return view("collector_muzakki_data_print.show", [
            "collector" => $collector,
            "muzakkis" => $muzakkis,
            "rowPerPage" => static::ROW_PER_PAGE,
        ]);
    }
}
