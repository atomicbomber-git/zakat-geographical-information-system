@php
    use Illuminate\Support\Facades\DB;
@endphp

@extends('shared.layout')
@section('title', 'Kelola Unit Pengumpulan Zakat')
@section('content')
<div class="container mt-5">
    <h1 class="mb-5">
        <i class="fa fa-building"></i>
        Unit Pengumpulan Zakat
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.short_name') }} </li>
            <li class="breadcrumb-item active"> Unit Pengumpulan Zakat </li>
        </ol>
    </nav>

    <div class="text-right">
        <a href="{{ route('collector.create') }}" class="btn btn-dark btn-sm">
            Tambah Unit Pengumpulan Zakat
        </a>
    </div>

    @include('shared.message', ['session_key' => 'message.success', 'state' => 'success'])

    <div class="my-3">
        <div class="alert alert-info">
            <form class="form-inline text-right" method="GET">
                <label for="year" class="ml-auto mr-2"> Tahun Laporan: </label>
                <select class="form-control form-control-sm mr-2" name="year" id="year">
                    @foreach ($available_years as $av_year)
                    <option value="{{ $av_year }}">
                        {{ $av_year }}
                    </option>
                    @endforeach
                </select>

                <button formaction="{{ route('admin-report.print-index') }}" class="btn btn-dark btn-sm mr-2">
                    Cetak Laporan Penerimaan
                    <i class="fa fa-print"></i>
                </button>

                <button formaction="{{ route('donation.printIndex') }}" class="btn btn-dark btn-sm">
                    Cetak Laporan Pemberian
                    <i class="fa fa-print"></i>
                </button>
            </form>
        </div>
    </div>

    <div id="app">
        <div class="card">
            <div class="card-body">
                <collector-chart
                    name="collector_chart"
                    title="Perkembangan Jumlah Nominal Laporan Penerimaan dan Pendistribusian Zakat (Dalam Jutaan Rupiah)"
                    :data='{{ json_encode($chart_data) }}'
                >
                </collector-chart>
            </div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-building"></i>
            Unit Pengumpulan Zakat
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong> Menampilkan laporan pemberian dan penerimaan zakat untuk tahun {{ $year }} </strong>

                <form class="form-inline mt-2 mb-4" method="GET">
                    <label for="year" class="mr-2"> Ubah ke Tahun Lain: </label>
                    <select name="year" id="year" class="form-control form-control-sm mr-2">
                        @foreach ($available_years as $available_year)
                        <option value="{{ $available_year }}" {{ $available_year == $year ? 'selected' : '' }}>
                            {{ $available_year }}
                        </option>
                        @endforeach
                    </select>

                    <button class="btn btn-dark btn-sm"> Ubah Tahun </button>
                </form>
            </div>

            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Nama Administrator </th>
                        <th> Nama Pengguna </th>
                        <th class="text-center"> UPZ </th>
                        <th class="text-right"> Total Penerimaan </th>
                        <th class="text-right"> Total Pemberian </th>
                        <th> NPWZ </th>
                        <th class="text-center"> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collectors as $collector)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $collector->user->name }} </td>
                        <td> {{ $collector->user->username }} </td>
                        <td class="text-center">
                            <div>
                                {{ $collector->name }}
                            </div>
                            <div>
                                <span class="badge badge-primary"> Muzakki: {{ $collector->muzakkis_count }} </span>
                                <span class="badge badge-primary"> Mustahiq: {{ $collector->mustahiqs_count }} </span>
                            </div>
                        </td>
                        <td class="text-right"> {{ number_format($collector->report_sum) }} </td>
                        <td class="text-right"> {{ number_format($collector->donation_sum) }} </td>
                        <td> {{ $collector->npwz }} </td>
                        <td class="text-center">
                            <div class="mb-2 d-flex justify-content-center"">
                                <a href="{{ route('admin-report.detail', ['collector' => $collector, 'year' => $year]) }}" class="btn btn-dark btn-sm mr-2">
                                    Penerimaan
                                </a>

                                <a href="{{ route('donation.detail', ['collector' => $collector, 'year' => $year]) }}" class="btn btn-dark btn-sm">
                                    Pemberian
                                </a>
                            </div>

                            <div class="d-flex justify-content-center">
                                <a href="{{ route('collector.show', $collector) }}" class="btn btn-dark btn-sm mr-2">
                                    <i class="fa fa-list"></i>
                                </a>

                                <a href="{{ route('collector.edit', $collector) }}" class="btn btn-dark btn-sm mr-2">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <form
                                    class="form-delete d-inline-block"
                                    action="{{ route('collector.delete', $collector) }}"
                                    method="POST">
                                    @csrf
                                    <button {{ Auth::user()->can("delete", $collector) ? '' : 'disabled' }} class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section("script")
    @include("shared.datatables")
@endsection
