<?php

namespace App\Http\Controllers;

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

        $receivements = Receivement::query()
            ->select(
                'id', 'transaction_date', 'muzakki_id', 'zakat', 'fitrah', 'infak',
                DB::raw('(zakat + fitrah + infak) AS total')
            )
            ->with('muzakki')
            ->where('collector_id', auth()->user()->collector->id)
            ->whereYear('transaction_date', $year)
            ->get();

        $yearly_receivements = Receivement::query()
            ->select(
                DB::raw('SUM(zakat) AS zakat'), DB::raw('SUM(fitrah) AS fitrah'), DB::raw('SUM(infak) AS infak'),
                DB::raw('(SUM(zakat) + SUM(fitrah) + SUM(infak)) AS total'), 
                DB::raw('YEAR(transaction_date) AS year'))
            ->where('collector_id', auth()->user()->collector->id)
            ->groupBy('year')
            ->get();


        return view('collector.receivement.index', compact('year', 'available_years', 'receivements', 'yearly_receivements'));
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
            'infak' => 'required|numeric|gte:0',
        ]);
        
        $data['collector_id'] = auth()->user()->collector->id;
        Receivement::create($data);

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
            'infak' => 'required|numeric|gte:0',
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
