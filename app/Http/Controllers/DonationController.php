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

        $yearly_donations = Donation::query()
            ->select(DB::raw('SUM(amount) AS amount'), DB::raw('YEAR(transaction_date) AS year'))
            ->groupBy('year')
            ->get();

        return view('donation.index', compact('year', 'available_years', 'yearly_donations', 'collectors'));
    }

    public function printIndex()
    {
        $year = request('year') ?? today()->format('Y');

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

        return view('donation.printIndex', compact('collectors', 'year'));
    }

    public function detail(Collector $collector)
    {
        $year = request('year') ?: abort(404);

        $donations = Donation::query()
            ->select(
                "id", "transaction_date", "mustahiq_id",
                "amount"
            )
            ->with("mustahiq")
            ->orderByDesc('transaction_date')
            ->where('collector_id', $collector->id)
            ->whereYear('transaction_date', $year)
            ->get();

        $yearly_donations = Donation::query()
            ->select(DB::raw('SUM(amount) AS amount'), DB::raw('YEAR(transaction_date) AS year'))
            ->where('collector_id', $collector->id)
            ->groupBy('year')
            ->get();

        return view('donation.detail', compact('collector', 'donations', 'year', 'yearly_donations'));
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
