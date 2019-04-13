<?php

namespace App\Http\Controllers;

use App\Mustahiq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class MustahiqController extends Controller
{
    public function index()
    {
        $mustahiqs = Mustahiq::query()
            ->select(
                "id", "name", "nik", "address",
                "kecamatan", "kelurahan", "phone", "gender",
                "occupation", "asnaf", "help_program" ,
                "collector_id", "age"
            )
            ->whereHas("collector", function (Builder $query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->orderBy("name")
            ->withCount("donations")
            ->get();
        
        return view("mustahiq.index", compact("mustahiqs"));
    }
    
    public function create()
    {
        $mustahiqs = Mustahiq::query()
            ->select("name", "id", "latitude", "longitude", "address")
            ->whereHas("collector", function ($query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->orderBy("name")
            ->get();

        $collector = Auth::user()->collector;
        return view("mustahiq.create", compact("mustahiqs", "collector"));
    }
    
    public function store()
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'nik' => 'required|string',
            'age' => 'required|gte:1',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'gender' => ['required', Rule::in('l', 'p')],
            'occupation' => 'required|string',
            'asnaf' => 'required|string',
            'help_program' => 'required|string',
        ]);

        Mustahiq::create(array_merge($data, [
            "collector_id" => Auth::user()->collector->id,
        ]));

        session()->flash('message-success', __('messages.create.success'));
    }
    
    public function edit(Mustahiq $mustahiq)
    {
        $this->authorize("update", $mustahiq);

        $mustahiqs = Mustahiq::query()
            ->select("name", "id", "latitude", "longitude", "address")
            ->whereHas("collector", function ($query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->orderBy("name")
            ->get();

        $collector = Auth::user()->collector;
        return view("mustahiq.edit", compact("mustahiq", "collector", "mustahiqs"));
    }
    
    public function update(Mustahiq $mustahiq)
    {
        $this->authorize("update", $mustahiq);

        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'nik' => 'required|string',
            'age' => 'required|gte:1',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'gender' => ['required', Rule::in('l', 'p')],
            'occupation' => 'required|string',
            'asnaf' => 'required|string',
            'help_program' => 'required|string',
        ]);

        $mustahiq->update($data);
        session()->flash('message-success', __('messages.update.success'));
    }
    
    public function delete(Mustahiq $mustahiq)
    {
        $mustahiq->donations_count = $mustahiq->donations()->count();
        $this->authorize("delete", $mustahiq);

        $mustahiq->delete();
        
        return back()
            ->with("message-success", __("messages.delete.success"));
    }
}
