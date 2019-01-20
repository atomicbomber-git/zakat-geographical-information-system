<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;
use App\Receiver;

class GuestController extends Controller
{
    public function map()
    {
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude')
            ->with([
                'donations' => function($query) {
                    $query->select('id', 'collector_id', 'name', 'latitude', 'longitude', 'address');
                    $query->whereYear('transaction_date', today()->format('Y'));
                }
            ])
            ->get()
            ->transform(function($collector) {
                $collector->image_url = route('collector.thumbnail', $collector) . "?" . rand();
                return $collector;
            });

        return view('guest.map', compact('collectors'));
    }
}
