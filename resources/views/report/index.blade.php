@extends('shared.layout')
@section('title', 'Laporan Penerimaan Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-usd'></i>
        Laporan Penerimaan Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> Penerimaan Zakat </li>
        </ol>
    </nav>

    <div class="my-4 text-right">
        <a href="{{ route('report.create') }}" class="btn btn-dark btn-sm">
            Tambah Laporan Penerimaan Zakat
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div id="app">
        <report-chart
            name="report_chart"
            title="Perkembangan Jumlah Nominal Laporan Penerimaan Zakat (Dalam Jutaan Rupiah)"
            :data='{{ json_encode($yearly_reports) }}'
            />
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-usd"></i>
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
                            <th> Tanggal Transaksi </th>
                            <th class="text-right"> Zakat (Rp.) </th>
                            <th class="text-right"> Fitrah (Rp.) </th>
                            <th class="text-right"> Infak (Rp.) </th>
                            <th class="text-right"> Total (Rp.) </th>
                            <th class="text-center"> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $report->transaction_date->format('d-m-Y') }} </td>
                            <td class="text-right"> {{ number_format($report->zakat) }} </td>
                            <td class="text-right"> {{ number_format($report->fitrah) }} </td>
                            <td class="text-right"> {{ number_format($report->infak) }} </td>
                            <td class="text-right"> {{ number_format($report->total) }} </td>
                            <th class="text-center">
                                <a href="{{ route('report.edit', $report) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                
                                <form class="form-delete d-inline-block" action='{{ route('collector.receivement.delete', $report) }}' method='POST'>
                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td class="text-right"> Total: </td>
                            <td class="text-right"> {{ number_format($reports->sum('zakat')) }} </td>
                            <td class="text-right"> {{ number_format($reports->sum('fitrah')) }} </td>
                            <td class="text-right"> {{ number_format($reports->sum('infak')) }} </td>
                            <td class="text-right"> {{ number_format($reports->sum('total')) }} </td>
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