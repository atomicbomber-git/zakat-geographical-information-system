<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Donation;
use App\Collector;

class DonationController extends Controller
{
    public function index()
    {
        $available_years = Donation::query()
            ->select(DB::raw('YEAR(transaction_date) AS year'))
            ->orderByDesc('year')
            ->groupBy('year')
            ->pluck('year');

        $year = request('year') ?? $available_years->first();

        $collectors = Collector::select('id', 'name')
            ->with([
                'donations' => function ($query) use($year) {
                    $query->select(
                        'collector_id', DB::raw('SUM(amount) AS total')
                    );
                    $query->whereYear('transaction_date', $year);
                    $query->groupBy('collector_id');
                }
            ])
            ->get()
            ->transform(function($collector) {
                $collector->donation = $collector->donations->first();
                return $collector;
            });

        return view('donation.index', compact('year', 'available_years', 'collectors'));
    }

    public function detail(Collector $collector)
    {
        $year = request('year');

        $donations = Donation::query()
            ->select(
                "id", "transaction_date", "name", "nik", "address", "kecamatan", "kelurahan",
                "phone", "gender", "occupation", "ansaf", "help_program",
                "amount"
            )
            ->orderByDesc('transaction_date')
            ->where('collector_id', $collector->id)
            ->whereYear('transaction_date', $year)
            ->get();

        return view('donation.detail', compact('collector', 'donations', 'year'));
    }

    public function count(Collector $collector) {

        $year = request("year") ?? today()->format("Y");

        $collector->load([
            'donations' => function ($query) {
                $query->select('collector_id', DB::raw('COUNT(collector_id) AS count'), DB::raw('YEAR(transaction_date) AS year'));
                $query->groupBy('collector_id', 'year');
                $query->orderBy('year');
            }
        ]);

        return $collector->donations;
    }
}