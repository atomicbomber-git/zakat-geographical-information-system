<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CollectorController extends Controller
{
    public function index()
    {
        $collectors = Collector::select('name', 'user_id', 'npwz', 'id')
            ->with('user:id,name,username')
            ->get();

        return view('collector.index', compact('collectors'));
    }
    
    public function create()
    {
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude')
            ->get();

        return view('collector.create', compact('collectors'));
    }

    public function store()
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'collector_name' => 'required|string',
            'npwz' => 'required|string|unique:collectors',
            'user_name' => 'required|string', // User real name
            'username' => 'required|string|unique:users', // User login name
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = User::create([
            'name' => $data['user_name'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'type' => 'COLLECTOR'
        ]);

        Collector::create([
            'user_id' => $user->id,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'address' => $data['address'],
            'name' => $data['collector_name'],
            'npwz' => $data['npwz'],
        ]);

        session()->flash('message.success', __('messages.create.success'));

        return [
            "status" => "success",
            "redirect" => route('collector.index')
        ];
    }

    public function edit(Collector $collector)
    {
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude')
            ->with('user:name,username')
            ->get();

        return view('collector.edit', compact('collector', 'collectors'));
    }

    public function update(Collector $collector)
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'collector_name' => 'required|string',
            'npwz' => ['required', 'string', Rule::unique('collectors')->ignore($collector->id)],
            'user_name' => 'required|string', // User real name
            'username' => ['required', 'string', Rule::unique('users')->ignore($collector->user->id)], // User login name
            'password' => 'sometimes|nullable|string|min:8|confirmed',
        ]);

        $user_data = [
            'name' => $data['user_name'],
            'username' => $data['username'],
            'type' => 'COLLECTOR'
        ];

        if (!empty($data['password'])) {
            $user_data['password'] = bcrypt($data['password']);
        }

        DB::transaction(function() use($user_data, $data, $collector) {
            $collector->user->update($user_data);

            $collector->update([
                'address' => $data['address'],
                'name' => $data['collector_name'],
                'npwz' => $data['npwz'],
            ]);
        });

        session()->flash('message.success', __('messages.update.success'));

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
