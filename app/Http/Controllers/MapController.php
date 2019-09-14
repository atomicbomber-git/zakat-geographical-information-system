<?php

namespace App\Http\Controllers;

use App\Collector;
use App\Muzakki;
use App\Mustahiq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MapController extends Controller
{
    public function show()
    {
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude', 'kecamatan', 'kelurahan')
            ->with('mustahiqs')
            ->when(Gate::allows("see-muzakkis-on-map"),
                function ($query) {
                    $query->with('muzakkis');
                }
            )
            ->get()
            ->transform(function($collector) {
                $collector->image_url = route('collector.thumbnail', $collector) . "?" . rand();
                return $collector;
            });

        $can_see_muzakkis = Gate::allows("see-muzakkis-on-map");

        $kecamatans = collect()
            ->merge($can_see_muzakkis ? Muzakki::select("kecamatan", "kelurahan")->distinct()->get() : [])
            ->merge(Mustahiq::select("kecamatan", "kelurahan")->distinct()->get())
            ->merge(Collector::select("kecamatan", "kelurahan")->distinct()->get())
            ->unique(function ($record) {
                return $record->kecamatan . $record->kelurahan;
            })
            ->sortBy("kecamatan")
            ->values()
            ->groupBy("kecamatan");

        $collector = Auth::user()
            ->collector;

        return view('map.show',
            compact('collector', 'collectors', "kecamatans", "can_see_muzakkis")
        );
    }
}
