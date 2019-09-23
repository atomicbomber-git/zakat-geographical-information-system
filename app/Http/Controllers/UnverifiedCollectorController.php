<?php

namespace App\Http\Controllers;

use App\Collector;
use Illuminate\Http\Request;

class UnverifiedCollectorController extends Controller
{
    public function index()
    {
        $collectors = Collector::query()
            ->withoutGlobalScopes()
            ->unverified()
            ->with(["user" => function ($query) {
                $query->withoutGlobalScopes();
            }])
            ->get();

        return view("unverified_collector.index", compact("collectors"));
    }
}
