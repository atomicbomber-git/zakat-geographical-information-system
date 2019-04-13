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
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude', 'kecamatan', 'kelurahan')
            ->with('mustahiqs')
            ->with('muzakkis')
            ->get()
            ->transform(function($collector) {
                $collector->image_url = route('collector.thumbnail', $collector) . "?" . rand();
                return $collector;
            });

        $muzakkis_count = Muzakki::count();
        $mustahiqs_count = Mustahiq::count();

        $kecamatans = collect()
            ->merge(Muzakki::select("kecamatan")->distinct()->pluck("kecamatan"))
            ->merge(Mustahiq::select("kecamatan")->distinct()->pluck("kecamatan"))
            ->unique()
            ->sort()
            ->values();

        return view('guest.map', compact('collectors', "muzakkis_count", "mustahiqs_count", "kecamatans"));
    }
}
