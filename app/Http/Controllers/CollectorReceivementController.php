<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Receivement;

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
                'id', 'transaction_date', 'collector_id', 'name',
                'NIK', 'kecamatan', 'kelurahan', 'phone',
                'gender', 'npwz', 'zakat', 'fitrah', 'infak',
                DB::raw('(zakat + fitrah + infak) AS total')
            )
            ->where('collector_id', auth()->user()->collector->id)
            ->whereYear('transaction_date', $year)
            ->get();

        return view('collector.receivement.index', compact('year', 'available_years', 'receivements'));
    }
    
    public function create()
    {
        return view('collector.receivement.create');
    }
    
    public function store()
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'gender' => Rule::in(array_keys(Receivement::GENDERS)),
            'NIK' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'transaction_date' => 'required|date',
            'npwz' => 'required|string',
            'phone' => 'required|string',
            'zakat' => 'required|numeric|gte:0',
            'fitrah' => 'required|numeric|gte:0',
            'infak' => 'required|numeric|gte:0',
        ]);
        
        $data['collector_id'] = auth()->user()->collector->id;
        Receivement::create($data);

        return back()
            ->with('message-success', __('messages.create.success'));
    }
    
    public function edit(Receivement $receivement)
    {
        return view('collector.receivement.edit', compact('receivement'));
    }
    
    public function update(Receivement $receivement)
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'gender' => Rule::in(array_keys(Receivement::GENDERS)),
            'NIK' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'npwz' => 'required|string',
            'phone' => 'required|string',
            'transaction_date' => 'required|date',
            'zakat' => 'required|numeric|gte:0',
            'fitrah' => 'required|numeric|gte:0',
            'infak' => 'required|numeric|gte:0',
        ]);

        $receivement->update($data);

        return back()
            ->with('message-success', __('messages.update.success'));
    }
    
    public function delete(Receivement $receivement) {
        $receivement->delete();
        return back()
            ->with('message-success', __('messages.delete.success'));
    }
}
