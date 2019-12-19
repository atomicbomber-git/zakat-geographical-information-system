<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Mustahiq;
use App\Muzakki;
use App\Receivement;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MustahiqAndMuzakkiDataPrintController extends Controller
{
    const ROW_PER_PAGE = 10;

    public function show(Request $request)
    {
        $mustahiqs = Mustahiq::query()
            ->select(
                "id",
                "name",
                "address",
                "kecamatan",
                "kelurahan",
            )
            ->addSelect([
                "last_transaction_date" => Donation::query()
                    ->whereColumn("donations.mustahiq_id", "mustahiqs.id")
                    ->select("transaction_date")
                    ->orderByDesc("transaction_date")
                    ->limit(1)
            ])
            ->addSelect([
                "amount" => Donation::query()
                    ->whereColumn("donations.mustahiq_id", "mustahiqs.id")
                    ->selectRaw("COALESCE(SUM(amount), 0)")
                    ->limit(1)
            ])
            ->get();

        $muzakkis = Muzakki::query()
            ->select(
                "id",
                "name",
                "address",
                "kecamatan",
                "kelurahan",
            )
            ->orderBy("name")
            ->addSelect([
                "last_transaction_date" => Receivement::query()
                    ->whereColumn("receivements.muzakki_id", "muzakkis.id")
                    ->select("transaction_date")
                    ->orderByDesc("transaction_date")
                    ->limit(1)
            ])
            ->addSelect([
                "amount" => Receivement::query()
                    ->whereColumn("receivements.muzakki_id", "muzakkis.id")
                    ->selectRaw("SUM(COALESCE(zakat, 0) + COALESCE(fitrah, 0) + COALESCE(infak, 0) + COALESCE(sedekah, 0)) AS amount")
                    ->limit(1)
            ])
            ->get();

        $recordRowChunks = (new Collection)
            ->merge($mustahiqs->map(function ($mustahiq) {
                return [
                    "type" => get_class($mustahiq),
                    "value" => $mustahiq
                ];
            }))
            ->merge($muzakkis->map(function ($muzakki) {
                return [
                    "type" => get_class($muzakki),
                    "value" => $muzakki
                ];
            }))
            ->chunk(self::ROW_PER_PAGE);

        return view("mustahiq_and_muzakki_data_print.show", [
            "recordRowChunks" => $recordRowChunks,
            "rowPerPage" => static::ROW_PER_PAGE,
        ]);
    }
}
