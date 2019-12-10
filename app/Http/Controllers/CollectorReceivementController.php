<?php

namespace App\Http\Controllers;

use App\Mustahiq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Receivement;
use App\Muzakki;
use Illuminate\Support\Facades\Auth;

class CollectorReceivementController extends Controller
{
    public function index()
    {
        $available_years = Receivement::query()
            ->select(DB::raw('YEAR(transaction_date) AS year'))
            ->where('collector_id', auth()->user()->collector->id)
            ->orderByDesc('year')
            ->groupBy('year')
            ->pluck('year');

        $year = request('year') ?? $available_years->first();

        $yearly_receivements = Receivement::query()
            ->select(
                DB::raw('SUM(zakat) AS zakat'),
                DB::raw('SUM(fitrah) AS fitrah'),
                DB::raw('SUM(fitrah_beras) AS fitrah_beras'),
                DB::raw('SUM(sedekah) AS sedekah'),
                DB::raw('SUM(infak) AS infak'),
                DB::raw('(SUM(zakat) + SUM(fitrah) + SUM(infak) + SUM(sedekah)) AS total'),
                DB::raw('YEAR(transaction_date) AS year'),
            )
            ->where('collector_id', auth()->user()->collector->id)
            ->groupBy('year')
            ->get();



        $latest_muzakki_receivement_year_query =
            Receivement::query()
                ->selectRaw("YEAR(transaction_date)")
                ->whereColumn("muzakkis.id", "receivements.muzakki_id")
                ->orderByDesc("transaction_date")
                ->limit(1);

        $muzakkis = Muzakki::query()
            ->select(
                "id",
                "name",
                "NIK",
            )
            ->where('collector_id', auth()->user()->collector->id)
            ->selectSub(
                Receivement::query()
                    ->select("transaction_date")
                    ->whereColumn("muzakkis.id", "receivements.muzakki_id")
                    ->orderByDesc("transaction_date")
                    ->limit(1),
                "latest_receivement_date"
            )
            ->whereRaw("({$latest_muzakki_receivement_year_query->toSql()}) = ?", [$year])
            ->orderBy("name")
            ->get();

        $muzakkis_count = Muzakki::count();
        $mustahiqs_count = Mustahiq::count();

        return view('collector_receivement.index', compact(
            'year',
            'available_years',
            'yearly_receivements',
            'muzakkis',
            'muzakkis_count',
            'mustahiqs_count',
        ));
    }

    public function create()
    {
        $muzakkis = Muzakki::query()
            ->select("id", "name", "nik")
            ->whereHas("collector", function ($query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->orderBy("name")
            ->get();

        return view('collector.receivement.create', compact('muzakkis'));
    }

    public function store()
    {
        $data = $this->validate(request(), [
            'muzakki_id' => 'nullable|exists:muzakkis,id',
            'transaction_date' => 'required|date',
            'zakat' => 'required|numeric|gte:0',
            'fitrah' => 'required|numeric|gte:0',
            'fitrah_beras' => 'required|numeric|gte:0',
            'infak' => 'required|numeric|gte:0',
            'sedekah' => 'required|numeric|gte:0',
        ]);

        $data['collector_id'] = auth()->user()->collector->id;
        return Receivement::create($data);

        session()->flash('message-success', __('messages.create.success'));
    }

    public function edit(Receivement $receivement)
    {
        $muzakkis = Muzakki::query()
            ->select("id", "name", "nik")
            ->whereHas("collector", function ($query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->orderBy("name")
            ->get();

        return view('collector.receivement.edit', compact('receivement', 'muzakkis'));
    }

    public function update(Receivement $receivement)
    {
        $data = $this->validate(request(), [
            'muzakki_id' => 'nullable|exists:muzakkis,id',
            'transaction_date' => 'required|date',
            'zakat' => 'required|numeric|gte:0',
            'fitrah' => 'required|numeric|gte:0',
            'fitrah_beras' => 'required|numeric|gte:0',
            'infak' => 'required|numeric|gte:0',
            'sedekah' => 'required|numeric|gte:0',
        ]);

        $receivement->update($data);
        session()->flash('message-success', __('messages.update.success'));
    }

    public function delete(Receivement $receivement) {
        $receivement->delete();
        return back()
            ->with('message-success', __('messages.delete.success'));
    }
}
