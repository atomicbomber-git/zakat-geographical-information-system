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
            ->get();

        $receivers = Receiver::select('id', 'name', 'address', 'latitude', 'longitude')
            ->get();

        return view('guest.map', compact('collectors', 'receivers'));
    }
}
