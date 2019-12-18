<?php

namespace App\Http\Controllers;

use App\Mustahiq;
use App\Muzakki;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MustahiqAndMuzakkiDataPrint extends Controller
{
    public function show(Request $request)
    {
        $mustahiqs = Mustahiq::query()
            ->get();

        $muzakkis = Muzakki::query()
            ->get();

        $recordRows = (new Collection)
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
            }));


        return view("mustahiq_and_muzakki_data_print.show", compact(
            "mustahiqs",
            "muzakkis",
        ));
    }
}
