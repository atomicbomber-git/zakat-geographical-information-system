<?php

namespace App\Http\Controllers;

use App\Receivement;
use App\Muzakki;

class MuzakkiDataPrintController extends Controller
{
    const ROW_PER_PAGE = 24;

    public function show()
    {
        $muzakkis = Muzakki::query()
            ->select(
                "name",
                "address",
                "kecamatan",
                "kelurahan",
            )
            ->withReceivementLastTransactionDate()
            ->withReceivementAmountSum()
            ->orderBy("name")
            ->get();

        return view("muzakki_data_print.show", [
            "muzakkis" => $muzakkis,
            "rowPerPage" => static::ROW_PER_PAGE,
        ]);
    }
}
