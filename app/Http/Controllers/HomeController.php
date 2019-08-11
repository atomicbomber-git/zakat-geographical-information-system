<?php

namespace App\Http\Controllers;

use App\Collector;
use App\Muzakki;
use App\Mustahiq;
use App\Information;

class HomeController extends Controller
{
    public function show()
    {
        $description_text = Information::query()
            ->where("name", "Penjelasan Situs")
            ->first()
            ->description ?? '';

        $muzakkis_count = Muzakki::count();
        $mustahiqs_count = Mustahiq::count();
        $collectors_count = Collector::count();

        return view('home.show', compact('description_text', 'muzakkis_count', 'mustahiqs_count', 'collectors_count'));
    }
}
