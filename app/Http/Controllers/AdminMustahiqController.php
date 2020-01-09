<?php

namespace App\Http\Controllers;

use App\Collector;
use App\ViewModels\MustahiqIndexViewModel;

class AdminMustahiqController extends Controller
{
    public function index(Collector $collector)
    {
        return new MustahiqIndexViewModel($collector);

        return view("admin.mustahiq.index");
    }
}
