<?php

namespace App\Http\Controllers;

use App\Mustahiq;
use Illuminate\Http\Request;

class CollectorMustahiqDonationController extends Controller
{
    public function index(Request $request, Mustahiq $mustahiq)
    {
        $mustahiq->load(
            "donations"
        );

        return view("collector_mustahiq_donation.index", compact("mustahiq"));
    }
}
