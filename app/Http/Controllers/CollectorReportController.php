<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectorReportController extends Controller
{
    public function index()
    {
        return view('collector_report.index');
    }

    public function create()
    {

    }
}
