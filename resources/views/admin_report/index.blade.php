@extends('shared.layout')
@section('title', 'Laporan Penerimaan Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-money'></i>
        Laporan Penerimaan Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> Laporan Penerimaan Zakat </li>
        </ol>
    </nav>

    <div class="my-3">
        <form class="form-inline text-right" action="{{ route('admin-report.print-index') }}" method="GET">
            <label for="year" class="ml-auto mr-2"> Tahun Laporan: </label>
            <select class="form-control form-control-sm mr-2" name="year" id="year">
                @foreach ($available_years as $av_year)
                <option value="{{ $av_year }}">
                    {{ $av_year }}
                </option>
                @endforeach
            </select>

            <button class="btn btn-dark btn-sm">
                Cetak Laporan
                <i class="fa fa-print"></i>
            </button>
        </form>
    </div>

    <div class="card" id="app">
        <div class="card-body">
            <report-chart
                name="report_chart"
                title="Perkembangan Jumlah Nominal Laporan Penerimaan Zakat (Dalam Jutaan Rupiah)"
                :data='{{ json_encode($yearly_reports) }}'
                />
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-money"></i>
            Laporan Penerimaan Zakat
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong> Menampilkan laporan penerimaan zakat untuk tahun {{ $year }} </strong>

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

            <div class='table-responsive'>
                <table class='table table-sm table-bordered'>
                    <thead class="thead thead-dark">
                        <tr>
                            <th> # </th>
                            <th> UPZ </th>
                            <th class="text-right"> Nominal </th>
                            <th class="text-center"> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collectors as $collector)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $collector->name }} </td>
                            <td class="text-right"> {{ number_format($collector->report_total_amount["value"]) }} </td>
                            <td class="text-center">
                                <a href="{{ route('admin-report.detail', ['collector' => $collector, 'year' => $year]) }}" class="btn btn-dark btn-sm">
                                    Detail
                                    <i class="fa fa-list"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td class="text-right"> Total: </td>
                            <td class="text-right"> {{ number_format($collectors->sum('report_total_amount.value')) }} </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @include("shared.datatables")
@endsection
