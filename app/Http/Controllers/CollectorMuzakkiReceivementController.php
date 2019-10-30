<?php

namespace App\Http\Controllers;

use App\Muzakki;
use Illuminate\Http\Request;

class CollectorMuzakkiReceivementController extends Controller
{
    public function index(Request $request, Muzakki $muzakki)
    {
        $muzakki->load(
            "receivements"
        );

        return view("collector_muzakki_receivement.index", compact("muzakki"));
    }
}
