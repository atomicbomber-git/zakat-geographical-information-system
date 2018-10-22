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
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'collector_name' => 'required|string',
            'user_name' => 'required|string', // User real name
            'username' => 'required|string|unique:users', // User login name
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        User::create([
            'name' => $data['user_name'],
            'username' => $data['username'],
            'password' => bcrypt($data['password'])
        ]);

        Collector::create([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'address' => $data['address'],
            'name' => $data['collector_name']
        ]);

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
