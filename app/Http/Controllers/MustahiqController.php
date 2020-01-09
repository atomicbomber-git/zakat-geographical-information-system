<?php

namespace App\Http\Controllers;

use App\Collector;
use App\Mustahiq;
use App\ViewModels\MustahiqIndexViewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MustahiqController extends Controller
{
    public function index(Collector $collector)
    {
        return view("mustahiq.index", new MustahiqIndexViewModel(
            $collector
        ));
    }

    public function create(Collector $collector)
    {
        $mustahiqs = Mustahiq::query()
            ->select("name", "id", "latitude", "longitude", "address")
            ->whereHas("collector", function ($query) use ($collector) {
                $query->where("id", $collector);
            })
            ->orderBy("name")
            ->get();

        return view("mustahiq.create", compact("mustahiqs", "collector"));
    }

    public function store(Collector $collector)
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
            "collector_id" => $collector->id,
        ]));

        session()->flash('message-success', __('messages.create.success'));
    }

    public function edit(Collector $collector, Mustahiq $mustahiq)
    {
        $this->authorize("update", $mustahiq);

        $mustahiqs = Mustahiq::query()
            ->select("name", "id", "latitude", "longitude", "address")
            ->whereHas("collector", function ($query) use($collector) {
                $query->where("id", $collector);
            })
            ->orderBy("name")
            ->get();

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

        return redirect()
            ->route("collector.mustahiq.index", $mustahiq->collector)
            ->with("message-success", __("messages.delete.success"));
    }
}
