<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Receivement;
use App\Collector;

class ReceivementController extends Controller
{
    public function index()
    {
        $available_years = Receivement::query()
            ->select(DB::raw('YEAR(transaction_date) AS year'))
            ->orderByDesc('year')
            ->groupBy('year')
            ->pluck('year');

        $year = request('year') ?? $available_years->first();

        $collectors = Collector::select('id', 'name')
            ->with([
                'receivements' => function ($query) use($year) {
                    $query->select(
                        'collector_id', DB::raw('SUM(infak) AS infak'),
                        DB::raw('SUM(zakat) AS zakat'), DB::raw('SUM(fitrah) AS fitrah'),
                        DB::raw('(SUM(infak) + SUM(zakat) + SUM(fitrah)) AS subtotal')
                    );
                    $query->whereYear('transaction_date', $year);
                    $query->groupBy('collector_id');
                }
            ])
            ->get()
            ->transform(function($collector) {
                $collector->receivement = $collector->receivements->first();
                return $collector;
            });

        return view('receivement.index', compact('year', 'available_years', 'collectors'));
    }
    
    public function detail(Collector $collector)
    {
        $year = request('year');

        $receivements = Receivement::query()
            ->select(
                'id', 'transaction_date', 'collector_id', 'name',
                'NIK', 'kecamatan', 'kelurahan', 'phone',
                'gender', 'npwz', 'zakat', 'fitrah', 'infak',
                DB::raw('(zakat + fitrah + infak) AS total')
            )
            ->where('collector_id', $collector->id)
            ->whereYear('transaction_date', $year)
            ->get();

        return view('receivement.detail', compact('collector', 'receivements', 'year'));
    }
}