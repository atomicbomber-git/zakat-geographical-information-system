<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Donation;
use App\Collector;
use App\Mustahiq;
use Illuminate\Support\Facades\Auth;

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

        $latest_mustahiq_donation_date_query =
            Donation::query()
                ->selectRaw("YEAR(transaction_date)")
                ->whereColumn("mustahiqs.id", "donations.mustahiq_id")
                ->orderByDesc("transaction_date")
                ->limit(1);

        $mustahiqs = Mustahiq::query()
            ->select(
                "id",
                "name",
                "NIK",
            )
            ->selectSub(
                Donation::query()
                    ->selectRaw("transaction_date")
                    ->whereColumn("mustahiqs.id", "donations.mustahiq_id")
                    ->orderByDesc("transaction_date")
                    ->limit(1),
                "latest_donation_date",
            )
            ->orderBy("name")
            ->whereRaw("({$latest_mustahiq_donation_date_query->toSql()}) = ?", [$year])
            ->get();

        $donations = Donation::query()
            ->select(
                "id", "transaction_date", "mustahiq_id", "amount"
            )
            ->with("mustahiq")
            ->where('collector_id', auth()->user()->collector->id)
            ->whereYear('transaction_date', $year)
            ->get();

        $yearly_donations = Donation::query()
            ->select(DB::raw('SUM(amount) AS amount'), DB::raw('YEAR(transaction_date) AS year'))
            ->where('collector_id', auth()->user()->collector->id)
            ->groupBy('year')
            ->get();

        return view('collector.donation.index',
            compact(
                'mustahiqs',
                'year',
                'available_years',
                'yearly_donations'
            ));
    }

    public function create()
    {
        $mustahiqs = Mustahiq::query()
            ->select("name", "id", "nik")
            ->whereHas("collector", function ($query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->orderBy("name")
            ->get();

        return view('collector.donation.create', compact('mustahiqs'));
    }

    public function store()
    {
        $data = $this->validate(request(), [
            'transaction_date' => 'required|date',
            'amount' => 'required|gt:0',
            'mustahiq_id' => 'required|exists:mustahiqs,id'
        ]);

        Donation::create(array_merge($data, [
            "collector_id" => Auth::user()->collector->id
        ]));

        session()->flash('message-success', __('messages.create.success'));
    }

    public function edit(Donation $donation)
    {
        $mustahiqs = Mustahiq::query()
            ->select("name", "id", "nik")
            ->whereHas("collector", function ($query) {
                $query->where("id", Auth::user()->collector->id);
            })
            ->orderBy("name")
            ->get();

        $donation->load("mustahiq");
        return view('collector.donation.edit', compact('donation', 'mustahiqs'));
    }

    public function update(Donation $donation)
    {
        $data = $this->validate(request(), [
            'transaction_date' => 'required|date',
            'amount' => 'required|gt:0',
            'mustahiq_id' => 'required|exists:mustahiqs,id'
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
