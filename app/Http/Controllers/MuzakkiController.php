<?php

namespace App\Http\Controllers;

use App\Collector;
use App\Muzakki;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class MuzakkiController extends Controller
{
    public function index(Collector $collector)
    {
        $muzakkis = Muzakki::query()
            ->select(
                "id", "name", "NIK", "address", "kecamatan", "kelurahan",
                "phone", "gender", "npwz", "collector_id", "occupation",
            )
            ->withCount("receivements")
            ->whereHas("collector", function (Builder $query) use ($collector) {
                $query->where("id", $collector->id);
            })
            ->orderByDesc("updated_at")
            ->orderByDesc("created_at")
            ->get();

        return view("muzakki.index", compact("muzakkis", "collector"));
    }

    public function create(Collector $collector)
    {
        $muzakkis = Muzakki::query()
            ->select(
                "id", "name", "NIK", "address", "kecamatan", "kelurahan",
                "phone", "gender", "npwz", "collector_id", "latitude", "longitude"
            )
            ->withCount("receivements")
            ->whereHas("collector", function (Builder $query) use ($collector) {
                $query->where("id", $collector);
            })
            ->get();

        return view("muzakki.create", compact("muzakkis", "collector"));
    }

    public function store(Collector $collector)
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'nik' => 'required|string|numeric|unique:muzakkis',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'gender' => ['required', Rule::in('l', 'p')],
            'npwz' => 'nullable|string',
            'occupation' => 'required|string',
        ]);

        Muzakki::create(array_merge($data, [
            "collector_id" => $collector,
        ]));

        session()->flash('message-success', __('messages.create.success'));
    }

    public function edit(Collector $collector, Muzakki $muzakki)
    {
        $muzakkis = Muzakki::query()
            ->select(
                "id", "name", "NIK", "address", "kecamatan", "kelurahan",
                "phone", "gender", "npwz", "collector_id", "latitude", "longitude",
                "occupation",
            )
            ->withCount("receivements")
            ->whereHas("collector", function (Builder $query) use ($collector) {
                $query->where("id", $collector);
            })
            ->get();

        return view("muzakki.edit", compact("muzakki", "muzakkis", "collector"));
    }

    public function update(Muzakki $muzakki)
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'nik' => ['required', 'string', Rule::unique('muzakkis')->ignore($muzakki->id)],
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'occupation' => 'required|string',
            'gender' => ['required', Rule::in('l', 'p')],
            'npwz' => ['nullable', 'string'],
        ]);

        $muzakki->update($data);
        session()->flash('message-success', __('messages.update.success'));
    }

    public function delete(Muzakki $muzakki)
    {
        $muzakki->receivements_count = $muzakki->receivements()->count();
        $this->authorize("delete", $muzakki);

        $muzakki->delete();
        return back()
            ->with("message-success", __("messages.delete.success"));
    }
}
