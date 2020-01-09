<?php

namespace App\Http\Controllers;

use App\Collector;
use App\Muzakki;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollectorMuzakkiReceivementController extends Controller
{
    public function index(Muzakki $muzakki)
    {
        $muzakki->load([
            "receivements" => function (HasMany $hasMany) {
                $hasMany
                    ->select(
                        "id",
                        "muzakki_id",
                        "sedekah",
                        "zakat",
                        "fitrah",
                        "fitrah_beras",
                        "infak",
                        "transaction_date",
                    )
                    ->withAmount("total");
            }
        ]);

        return view("collector_muzakki_receivement.index", compact("muzakki"));
    }
}
