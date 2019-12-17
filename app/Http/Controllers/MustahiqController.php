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
                "occupation", "asnaf", "nomor_kk",
                "collector_id", "age", "description",
                "created_at",
                "updated_at",
                "program_bantuan",
            )
            ->whereHas("collector", function (Builder $query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->withCount("donations")
            ->orderByDesc("updated_at")
            ->orderByDesc("created_at")
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
            'nik' => 'required|numeric|string',
            'age' => 'required|numeric|gte:1',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'gender' => ['required', Rule::in('l', 'p')],
            'occupation' => 'required|string',
            'asnaf' => 'required|string',
            'nomor_kk' => 'required|numeric|string',
            'description' => 'required|string',
            'program_bantuan' => 'required|string',
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
            'age' => 'required|numeric|gte:1',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'gender' => ['required', Rule::in('l', 'p')],
            'occupation' => 'required|string',
            'asnaf' => 'required|string',
            'nomor_kk' => 'required|string',
            'description' => 'required|string',
            'program_bantuan' => 'required|string',
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
