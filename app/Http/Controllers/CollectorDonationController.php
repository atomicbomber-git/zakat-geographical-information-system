<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Donation;
use App\Collector;

class CollectorDonationController extends Controller
{
    public function index()
    {
        $available_years = Donation::query()
            ->select(DB::raw('YEAR(transaction_date) AS year'))
            ->where('collector_id', auth()->user()->collector->id)
            ->orderByDesc('year')
            ->groupBy('year')
            ->pluck('year');

        $year = request('year') ?? $available_years->first();

        $donations = Donation::query()
            ->select(
                "id", "transaction_date", "name", "nik", "address", "kecamatan", "kelurahan",
                "phone", "gender", "occupation", "ansaf", "help_program",
                "amount"
            )
            ->where('collector_id', auth()->user()->collector->id)
            ->whereYear('transaction_date', $year)
            ->get();

        $yearly_donations = Donation::query()
            ->select(DB::raw('SUM(amount) AS amount'), DB::raw('YEAR(transaction_date) AS year'))
            ->where('collector_id', auth()->user()->collector->id)
            ->groupBy('year')
            ->get();

        return view('collector.donation.index', compact('donations', 'year', 'available_years', 'yearly_donations'));
    }
    
    public function create()
    {
        $collectors = Collector::query()
            ->select('id', 'name', 'address', 'latitude', 'longitude')
            ->get()
            ->each(function ($collector) {
                $collector->image_url = route('collector.thumbnail', $collector);
                return $collector;
            });

        return view('collector.donation.create', compact('collectors'));
    }
    
    public function store()
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'transaction_date' => 'required|date',
            'name' => 'required|string',
            'nik' => 'required|string',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'gender' => ['required', Rule::in('l', 'p')],
            'occupation' => 'required|string',
            'ansaf' => 'required|string',
            'help_program' => 'required|string',
            'amount' => 'required|gt:0',
        ]);
        
        $data['collector_id'] = auth()->user()->collector->id;
        Donation::create($data);

        session()->flash('message-success', __('messages.create.success'));
    }
    
    public function edit(Donation $donation)
    {
        $collectors = Collector::query()
            ->select('id', 'name', 'address', 'latitude', 'longitude')
            ->get()
            ->each(function ($collector) {
                $collector->image_url = route('collector.thumbnail', $collector);
                return $collector;
            });

        $donation->original_gender = $donation->getOriginal('gender');

        return view('collector.donation.edit', compact('donation', 'collectors'));
    }
    
    public function update(Donation $donation)
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'nik' => 'required|string',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'gender' => ['required', Rule::in('l', 'p')],
            'occupation' => 'required|string',
            'ansaf' => 'required|string',
            'help_program' => 'required|string',
            'amount' => 'required|gt:0',
        ]);

        $donation->update($data);
        session()->flash('message-success', __('messages.update.success'));
    }
    
    public function delete(Donation $donation) {
        $donation->delete();
        return back()
            ->with('message-success', __('messages.delete.success'));
    }
}
