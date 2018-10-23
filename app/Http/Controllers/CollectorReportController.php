<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Collector;
use App\Report;

class CollectorReportController extends Controller
{
    public function index(Collector $collector)
    {
        $reports = Report::select('transaction_date', 'zakat', 'fitrah', 'infak', 'note')
            ->where('collector_id', $collector->id)
            ->get();

        return view('collector_report.index', compact('collector', 'reports'));
    }

    public function create(Collector $collector)
    {
        return view('collector_report.create', compact('collector'));
    }

    public function store(Collector $collector)
    {
        $data = $this->validate(request(), [
            'transaction_date' => 'string|required',
            'amount' => 'string|integer|min:1',
            'type' => ['required', Rule::in(array_keys(Report::TYPES))],
            'note' => 'string|required',
        ]);

        $data['collector_id'] = $collector->id;
        
        Report::create($data);

        return redirect()
            ->route('collector.report.index', $collector);
    }
}
