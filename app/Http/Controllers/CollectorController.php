<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;

class CollectorController extends Controller
{
    public function index()
    {
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude')->get();
        return view('collector.index', compact('collectors'));
    }

    public function store()
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'name' => 'required|string'
        ]);

        Collector::create($data);

        return [
            "status" => "success",
            "redirect" => route('collector.index')
        ];
    }

    public function delete($collector_id)
    {
        Collector::where('id', $collector_id)->delete();

        return [
            "status" => "success",
            "redirect" => route('collector.index')
        ];
    }
}
