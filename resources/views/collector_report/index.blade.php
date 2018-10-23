@extends('shared.layout')
@section('title', 'Kelola Laporan Zakat')
@section('content')
<div class="container mt-5">
    <h1>
        <i class="fa fa-list"></i>
        Kelola Laporan Zakat
    </h1>

    <div class="row">
        <div class="col text-left"></div>
        <div class="col-2"></div>
        <div class="col text-right">
            <a href="{{ route('collector.report.create', $collector) }}" class="btn btn-dark btn-sm">
                Tambah Laporan Zakat
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Seluruh Laporan Zakat
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Tanggal Transaksi </th>
                        <th> Jumlah </th>
                        <th> Tipe </th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $report->transaction_date }} </td>
                        <td> Rp. {{ number_format($report->amount) }} </td>
                        <td> {{ $report->type }} </td>
                        <td>  </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection