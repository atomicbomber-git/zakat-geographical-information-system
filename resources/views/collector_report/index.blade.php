@extends('shared.layout')
@section('title', 'Kelola Laporan Penerimaan Zakat')
@section('content')
<div class="container mt-5">
    <h1>
        <i class="fa fa-list"></i>
        Kelola Laporan Penerimaan Zakat
    </h1>

    <div class="row">
        <div class="col text-left"></div>
        <div class="col-2"></div>
        <div class="col text-right">
            <a href="{{ route('collector.report.create', $collector) }}" class="btn btn-dark btn-sm">
                Tambah Laporan Penerimaan Zakat
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>

    @include('shared.message', ['session_key' => 'message.success', 'state' => 'success'])

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Seluruh Laporan Penerimaan Zakat
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Tanggal Transaksi </th>
                        <th> Zakat (Rp.) </th>
                        <th> Fitrah (Rp.) </th>
                        <th> Infak (Rp.) </th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $report->transaction_date }} </td>
                        <td> {{ number_format($report->zakat) }} </td>
                        <td> {{ number_format($report->fitrah) }} </td>
                        <td> {{ number_format($report->infak) }} </td>
                        <td>
                            <a href="{{ route('collector.report.edit', $report) }}" class="btn btn-dark btn-sm">
                                Sunting
                                <i class="fa fa-pencil"></i>
                            </a>

                            <form class="form-delete" action="{{ route('collector.report.delete', $report) }}" method="POST" class="d-inline-block">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection