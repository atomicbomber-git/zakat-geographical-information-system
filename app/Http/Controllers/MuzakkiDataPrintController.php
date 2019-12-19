<?php

namespace App\Http\Controllers;

use App\Receivement;
use App\Muzakki;

class MuzakkiDataPrintController extends Controller
{
    const ROW_PER_PAGE = 8;

    public function show()
    {
        $muzakkis = Muzakki::query()
            ->select(
                "name",
                "address",
                "kecamatan",
                "kelurahan",
            )
            ->addSelect([
                "last_transaction_date" => Receivement::query()
                    ->whereColumn("muzakkis.id", "receivements.muzakki_id")
                    ->select("transaction_date")
                    ->orderByDesc("transaction_date")
                    ->limit(1)
            ])
            ->addSelect([
                "amount" => Receivement::query()
                    ->whereColumn("muzakkis.id", "receivements.muzakki_id")
                    ->selectRaw("SUM(
                        COALESCE(zakat, 0) +
                        COALESCE(fitrah, 0) +
                        COALESCE(infak, 0) +
                        COALESCE(sedekah, 0)
                    )")
                    ->limit(1)
            ])
            ->orderBy("name")
            ->get();

        return view("muzakki_data_print.show", [
            "muzakkis" => $muzakkis,
            "rowPerPage" => static::ROW_PER_PAGE,
        ]);
    }
}
