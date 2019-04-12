<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;
use App\Receiver;
use App\Muzakki;
use App\Mustahiq;

class GuestController extends Controller
{
    public function map()
    {
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude')
            ->with('mustahiqs')
            // ->with('muzakkis')
            ->get()
            ->transform(function($collector) {
                $collector->image_url = route('collector.thumbnail', $collector) . "?" . rand();
                return $collector;
            });

        $muzakkis_count = Muzakki::count();
        $mustahiqs_count = Mustahiq::count();

        return view('guest.map', compact('collectors', "muzakkis_count", "mustahiqs_count"));
    }
}
