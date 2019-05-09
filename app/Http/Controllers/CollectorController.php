<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CollectorController extends Controller
{
    public function index()
    {
        $collectors = Collector::select('name', 'user_id', 'npwz', 'id')
            ->with('user:id,name,username')
            ->withCount(Collector::HAS_RELATIONS)
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
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'collector_name' => 'required|string',
            'npwz' => 'required|string|unique:collectors',
            'user_name' => 'required|string', // User real name
            'username' => 'required|string|unique:users', // User login name
            'password' => 'required|string|min:8|confirmed',
            'picture' => 'required|file|mimes:jpg,jpeg,png'
        ]);

        DB::transaction(function() use($data) {
            $user = User::create([
                'name' => $data['user_name'],
                'username' => $data['username'],
                'password' => bcrypt($data['password']),
                'type' => 'COLLECTOR'
            ]);
    
            $collector = Collector::create([
                'user_id' => $user->id,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'address' => $data['address'],
                'name' => $data['collector_name'],
                'npwz' => $data['npwz'],
            ]);

            $collector->addMediaFromRequest('picture')->toMediaCollection('images');
        });

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
            ->get()
            ->transform(function($collector) {
                $collector->image_url = route('collector.thumbnail', $collector) . "?" . rand();
                return $collector;
            });
        
        $collector->load('user');

        return view('collector.edit', compact('collector', 'collectors'));
    }

    public function update(Collector $collector)
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'collector_name' => 'required|string',
            'npwz' => ['required', 'string', Rule::unique('collectors')->ignore($collector->id)],
            'user_name' => 'required|string', // User real name
            'username' => ['required', 'string', Rule::unique('users')->ignore($collector->user->id)], // User login name
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'picture' => 'sometimes|nullable|file|mimes:jpg,jpeg,png'
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
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'address' => $data['address'],
                'name' => $data['collector_name'],
                'npwz' => $data['npwz'],
            ]);

            // A picture replacement was uploaded
            if(!empty($data['picture'])) {
                // Clear the old one
                $collector->clearMediaCollection('images');

                // Store a new one
                $collector->addMediaFromRequest('picture')->toMediaCollection('images');
            }
        });

        session()->flash('message.success', __('messages.update.success'));

        return [
            "status" => "success",
            "redirect" => route('collector.index')
        ];
    }

    public function delete(Collector $collector)
    {
        if (! Auth::user()->can("delete", $collector)) {
            return back()
                ->with("message.danger", __('messages.delete.failure'));
        }

        $collector->delete();

        return back()
            ->with('message.success', __('messages.delete.success'));
    }

    public function thumbnail(Collector $collector)
    {
        return response()->file($collector->getFirstMedia('images')->getPath());
    }
}
