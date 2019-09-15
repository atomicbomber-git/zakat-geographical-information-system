<?php

namespace App\Http\Controllers;

use App\Muzakki;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class MuzakkiController extends Controller
{
    public function index()
    {
        $muzakkis = Muzakki::query()
            ->select(
                "id", "name", "NIK", "address", "kecamatan", "kelurahan",
                "phone", "gender", "npwz", "collector_id", "occupation",
            )
            ->withCount("receivements")
            ->whereHas("collector", function (Builder $query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->orderByDesc("updated_at")
            ->orderByDesc("created_at")
            ->get();

        return view("muzakki.index", compact("muzakkis"));
    }

    public function create()
    {
        $muzakkis = Muzakki::query()
            ->select(
                "id", "name", "NIK", "address", "kecamatan", "kelurahan",
                "phone", "gender", "npwz", "collector_id", "latitude", "longitude"
            )
            ->withCount("receivements")
            ->whereHas("collector", function (Builder $query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->get();

        $collector = Auth::user()->collector;

        return view("muzakki.create", compact("muzakkis", "collector"));
    }

    public function store()
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'nik' => 'required|string|unique:muzakkis',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'gender' => ['required', Rule::in('l', 'p')],
            'npwz' => 'nullable|string',
            'occupation' => 'required|string',
        ]);

        Muzakki::create(array_merge($data, [
            "collector_id" => Auth::user()->collector->id,
        ]));

        session()->flash('message-success', __('messages.create.success'));
    }

    public function edit(Muzakki $muzakki)
    {
        $muzakkis = Muzakki::query()
            ->select(
                "id", "name", "NIK", "address", "kecamatan", "kelurahan",
                "phone", "gender", "npwz", "collector_id", "latitude", "longitude",
                "occupation",
            )
            ->withCount("receivements")
            ->whereHas("collector", function (Builder $query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->get();

        $collector = Auth::user()->collector;

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
