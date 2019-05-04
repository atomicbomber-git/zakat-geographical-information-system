<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;
use App\Receiver;
use App\Muzakki;
use App\Mustahiq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

class GuestController extends Controller
{
    public function map()
    {
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude', 'kecamatan', 'kelurahan')
            ->with('mustahiqs')
            ->when(Gate::allows("see-muzakkis-on-map"),
                function (Builder $query) {
                    $query->with('muzakkis');
                }
            )
            ->get()
            ->transform(function($collector) {
                $collector->image_url = route('collector.thumbnail', $collector) . "?" . rand();
                return $collector;
            });

        $muzakkis_count = Muzakki::count();
        $mustahiqs_count = Mustahiq::count();

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
            
        return view('guest.map',
            compact('collectors', "muzakkis_count", "mustahiqs_count", "kecamatans", "can_see_muzakkis")
        );
    }
}
