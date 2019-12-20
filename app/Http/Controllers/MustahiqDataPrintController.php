<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Mustahiq;
use Illuminate\Http\Request;

class MustahiqDataPrintController extends Controller
{
    const ROW_PER_PAGE = 24;

    public function show(Request $request)
    {
        $mustahiqs = Mustahiq::query()
            ->select(
                "name",
                "address",
                "kecamatan",
                "kelurahan",
            )
            ->addSelect([
                "last_transaction_date" => Donation::query()
                    ->whereColumn("mustahiqs.id", "donations.mustahiq_id")
                    ->select("transaction_date")
                    ->orderByDesc("transaction_date")
                    ->limit(1)
            ])
            ->addSelect([
                "amount" => Donation::query()
                    ->whereColumn("mustahiqs.id", "donations.mustahiq_id")
                    ->selectRaw("SUM(amount)")
                    ->limit(1)
            ])
            ->orderBy("name")
            ->get();

        return view("mustahiq_data_print.show", [
            "mustahiqs" => $mustahiqs,
            "rowPerPage" => static::ROW_PER_PAGE,
        ]);
    }
}
