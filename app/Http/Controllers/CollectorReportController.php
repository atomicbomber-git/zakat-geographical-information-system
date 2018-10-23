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
        $reports = Report::select('transaction_date', 'zakat', 'fitrah', 'infak', 'note', 'id')
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
            'zakat' => 'required|numeric|min:1',
            'fitrah' => 'required|numeric|min:1',
            'infak' => 'required|numeric|min:1',
            'note' => 'string|required',
        ]);

        $data['collector_id'] = $collector->id;
        
        Report::create($data);

        return redirect()
            ->route('collector.report.index', $collector);
    }

    public function delete(Report $report)
    {
        $report->delete();

        return redirect()
            ->back()
            ->with('message.success', __('messages.delete.success'));
    }
}
