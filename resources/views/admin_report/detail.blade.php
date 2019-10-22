@php
    use App\Helper\Formatter;
@endphp

@extends('shared.layout')
@section('title', 'Detail Laporan Penerimaan Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-money'></i>
        Detail Laporan Penerimaan Zakat
        <p class="lead">
            {{ $collector->name }} <br/>
            Tahun {{ request("year") }}
        </p>
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item">
                <a href="{{ route("collector.index", compact("year")) }}">
                    Unit Pengumpul Zakat
                </a>
            </li>
            <li class="breadcrumb-item active">
                Detail Laporan Penerimaan Zakat
            </li>
        </ol>
    </nav>

    <div class="card mb-3" id="app">
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
            Detail Laporan Penerimaan Zakat
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead class="thead thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Tanggal Transaksi </th>
                            <th class="text-right"> Zakat Mal (Rp.) </th>
                            <th class="text-right"> Zakat Fitrah Tunai (Rp.) </th>
                            <th class="text-right"> Zakat Fitrah Beras (Kg.) </th>
                            <th class="text-right"> Infak (Rp.) </th>
                            <th class="text-right"> Sedekah (Rp.) </th>
                            <th class="text-right"> Total (Rp.) </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collector->reports as $report)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ Formatter::date($report->transaction_date) }} </td>
                            <td class="text-right"> {{ Formatter::currency($report->zakat) }} </td>
                            <td class="text-right"> {{ Formatter::currency($report->fitrah) }} </td>
                            <td class="text-right"> {{ Formatter::currency($report->fitrah_beras) }} </td>
                            <td class="text-right"> {{ Formatter::currency($report->infak) }} </td>
                            <td class="text-right"> {{ Formatter::currency($report->sedekah) }} </td>
                            <td class="text-right"> {{ Formatter::currency($report->total) }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td class="text-right"> {{ Formatter::currency($collector->reports->sum('zakat')) }} </td>
                            <td class="text-right"> {{ Formatter::currency($collector->reports->sum('fitrah')) }} </td>
                            <td class="text-right"> {{ Formatter::currency($collector->reports->sum('fitrah_beras')) }} </td>
                            <td class="text-right"> {{ Formatter::currency($collector->reports->sum('infak')) }} </td>
                            <td class="text-right"> {{ Formatter::currency($collector->reports->sum('sedekah')) }} </td>
                            <td class="text-right"> {{ Formatter::currency($collector->reports->sum('total')) }} </td>
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
