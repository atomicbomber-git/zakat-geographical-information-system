<?php

namespace App\Http\Controllers;

use App\Collector;
use App\Donation;
use App\Mustahiq;
use App\Muzakki;
use App\Receivement;
use App\Report;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CollectorController extends Controller
{
    public function index()
    {
        $available_years = $this->getReportAndDonationAvailableYears();
        $year = request('year') ?? ($available_years->first() ?? now()->format('Y'));

        $collectors = Collector::select('name', 'user_id', 'reg_number', 'id', 'created_at')
            ->with('user:id,name,username')
            ->selectSub(
                Donation::query()
                    ->select(DB::raw("SUM(amount) AS amount"))
                    ->whereColumn((new Donation)->getTable() . ".collector_id", (new Collector)->getTable() . ".id")
                    ->whereYear("transaction_date", $year)
                    ->limit(1)
            , "donation_sum")
            ->selectSub(
                Report::query()
                    ->withAmount()
                    ->whereColumn((new Report)->getTable() . ".collector_id", (new Collector)->getTable() . ".id")
                    ->whereYear("transaction_date", $year)
                    ->limit(1)
            , "report_sum")
            ->orderByDesc("updated_at")
            ->orderByDesc("created_at")
            ->withCount(Collector::HAS_RELATIONS)
            ->get();

        $yearly_donations = Donation::query()
            ->select(DB::raw('SUM(amount) AS amount'), DB::raw('YEAR(transaction_date) AS year'))
            ->groupBy("year")
            ->get()
            ->keyBy("year");

        $yearly_reports = Report::query()
            ->select(DB::raw('YEAR(transaction_date) AS year'))
            ->withAmount()
            ->groupBy('year')
            ->get()
            ->keyBy('year')
            ;

        $chart_data = $available_years->map(function ($year) use($yearly_donations, $yearly_reports) {
            return [
                "year" => $year,
                "donation" => $yearly_donations[$year]->amount ?? 0,
                "report" => $yearly_reports[$year]->amount ?? 0,
            ];
        });

        $muzakkis_count = Muzakki::count();
        $mustahiqs_count = Mustahiq::count();
        $collectors_count = Collector::count();

        return view('collector.index', compact(
            'collectors',
            'year',
            'available_years',
            'chart_data',
            'muzakkis_count',
            'mustahiqs_count',
            'collectors_count',
        ));
    }

    public function show(Collector $collector)
    {
        $collector->load([
            "muzakkis",
            "mustahiqs",
        ]);

        $collector->members = $collector
            ->members()
            ->select(
                "collector_id",
                "id",
                "name",
                "position",
            )
            ->get()
            ->pluck("name", "position");

        return view("collector.show", compact("collector"));
    }

    public function create()
    {
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude')
            ->get();

        return view('collector.create', compact('collectors'));
    }

    public function store()
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|numeric|string',
            'penasehat' => 'required|string',
            'ketua' => 'required|string',
            'sekretaris' => 'required|string',
            'bendahara' => 'required|string',
            'anggota_1' => 'nullable|string',
            'anggota_2' => 'nullable|string',
            'collector_name' => 'required|string',
            'reg_number' => 'required|numeric|unique:' . (new Collector)->getTable(),
            'admin_name' => 'required|string', // User real name
            'username' => 'required|string|alpha_dash|unique:users', // User login name
            'password' => 'required|string|min:8|confirmed',
            'picture' => 'required|file|mimes:jpg,jpeg,png'
        ]);

        DB::transaction(function() use($data) {
            $user = User::create([
                'name' => $data['admin_name'],
                'username' => $data['username'],
                'password' => bcrypt($data['password']),
                'type' => 'COLLECTOR'
            ]);

            $collector = Collector::create([
                'user_id' => $user->id,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'name' => $data['collector_name'],
                'reg_number' => $data['reg_number'],
                'is_verified' => 1,
            ]);

            collect([
                "penasehat",
                "ketua",
                "sekretaris",
                "bendahara",
                "anggota_1",
                "anggota_2",
            ])
            ->each(function ($field) use($data, $collector) {
                if (empty($data[$field])) {
                    return;
                }

                $collector->members()
                    ->create([
                        "position" => $field,
                        "name" => $data[$field],
                    ]);
            });

            $collector->addMediaFromRequest('picture')
                ->toMediaCollection('images');
        });

        session()->flash('message.success', __('messages.create.success'));
    }

    public function edit(Collector $collector)
    {
        $collectors = Collector::select('id', 'name', 'address', 'latitude', 'longitude')
            ->with('user:name,username')
            ->get()
            ->transform(function($collector) {
                $collector->image_url = route('collector.thumbnail', $collector) . "?" . rand();
                return $collector;
            });

        $collector->load([
            "user",
        ]);

        $collector->members =
            $collector->members()
                ->get()
                ->keyBy("position");

        return view('collector.edit', compact('collector', 'collectors'));
    }

    public function update(Collector $collector)
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'phone' => 'required|string',
            'penasehat' => 'required|string',
            'ketua' => 'required|string',
            'sekretaris' => 'required|string',
            'bendahara' => 'required|string',
            'anggota_1' => 'nullable|string',
            'anggota_2' => 'nullable|string',
            'collector_name' => 'required|string',
            'reg_number' => ['required', 'string', Rule::unique((new Collector)->getTable())->ignore($collector->id)],
            'admin_name' => 'required|string', // User real name
            'username' => ['required', 'string', Rule::unique((new User)->getTable())->ignore($collector->user->id)], // User login name
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'picture' => 'sometimes|nullable|file|mimes:jpg,jpeg,png'
        ]);

        $user_data = [
            'name' => $data['admin_name'],
            'username' => $data['username'],
            'type' => 'COLLECTOR'
        ];

        if (!empty($data['password'])) {
            $user_data['password'] = bcrypt($data['password']);
        }

        DB::transaction(function() use($user_data, $data, $collector) {
            $collector->user->update($user_data);

            $collector->update([
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'name' => $data['collector_name'],
                'reg_number' => $data['reg_number'],
            ]);

            $collector->members()->delete();

            collect([
                "penasehat",
                "ketua",
                "sekretaris",
                "bendahara",
                "anggota_1",
                "anggota_2",
            ])
            ->each(function ($field) use($data, $collector) {
                if (empty($data[$field])) {
                    return;
                }

                $collector->members()
                    ->create([
                        "position" => $field,
                        "name" => $data[$field],
                    ]);
            });

            // A picture replacement was uploaded
            if(!empty($data['picture'])) {
                // Clear the old one
                $collector->clearMediaCollection('images');

                // Store a new one
                $collector->addMediaFromRequest('picture')->toMediaCollection('images');
            }
        });

        session()->flash('message.success', __('messages.update.success'));

        return [
            "status" => "success",
            "redirect" => route('collector.index')
        ];
    }

    public function delete(Collector $collector)
    {
        if (! Auth::user()->can("delete", $collector)) {
            return back()
                ->with("message.danger", __('messages.delete.failure'));
        }

        DB::transaction(function () use ($collector) {
            $collector->members()->delete();
            $collector->delete();
        });

        return back()
            ->with('message.success', __('messages.delete.success'));
    }

    public function thumbnail(Collector $collector)
    {
        return response()->file($collector->getFirstMedia('images')->getPath());
    }

    private function getReportAndDonationAvailableYears()
    {
        $report_years = Report::query()
            ->select(DB::raw('YEAR(transaction_date) AS year'))
            ->orderByDesc('year')
            ->groupBy('year')
            ->get()
            ->pluck('year');

        $donation_years = Donation::query()
            ->select(DB::raw('YEAR(transaction_date) AS year'))
            ->orderByDesc('year')
            ->groupBy('year')
            ->pluck('year');

        return collect()->merge($report_years)->merge($donation_years)->unique();
    }
}
