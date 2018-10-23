@extends('shared.layout')
@section('title', 'Kelola Laporan Zakat')
@section('content')
<div class="container mt-5">
    <h1>
        <i class="fa fa-usd"></i>
        Kelola Laporan Zakat
    </h1>

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-usd"></i>
            Kelola Laporan Zakat
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Tanggal Transaksi </th>
                        <th> NPWZ </th>
                        <th style="width: 3rem"> Nama </th>
                        <th> Zakat (Rp.) </th>
                        <th> Fitrah (Rp.) </th>
                        <th> Infak (Rp.) </th>
                        <th> Keterangan </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $report->transaction_date }} </td>
                        <td> {{ $report->collector->npwz }} </td>
                        <td> {{ $report->collector->name  }} </td>
                        <td> {{ number_format($report->zakat) }} </td>
                        <td> {{ number_format($report->fitrah) }} </td>
                        <td> {{ number_format($report->infak) }} </td>
                        <td> {{ $report->note  }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection