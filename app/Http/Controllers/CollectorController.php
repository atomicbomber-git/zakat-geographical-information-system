<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;
use App\User;

class CollectorController extends Controller
{
    public function index()
    {
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude')->get();
        return view('collector.index', compact('collectors'));
    }

    public function store()
    {
        $data = collect($this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]));

        $data->put('password', bcrypt($data->get('password')));

        User::create($data->only('name', 'username', 'password')->toArray());
        Collector::create($data->only('latitude', 'longitude', 'name', 'address')->toArray());

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
