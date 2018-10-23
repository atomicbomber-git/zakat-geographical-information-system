<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;

class CollectorUserController extends Controller
{
    public function index()
    {
        $collectors = Collector::select('name', 'user_id', 'npwz')
            ->with('user:id,name,username')
            ->get();

        return view('collector_user.index', compact('collectors'));
    }
}
