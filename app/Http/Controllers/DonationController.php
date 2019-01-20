<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Donation;
use App\Collector;

class DonationController extends Controller
{
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
