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
            ->withDonationsLastTransactionDate()
            ->withDonationsAmountSum()
            ->orderBy("name")
            ->get();

        return view("mustahiq_data_print.show", [
            "mustahiqs" => $mustahiqs,
            "rowPerPage" => static::ROW_PER_PAGE,
        ]);
    }
}
