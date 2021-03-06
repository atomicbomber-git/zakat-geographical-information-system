@extends('shared.layout')
@section('title', 'Penerimaan Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-arrow-down'></i>
        Penerimaan Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> Penerimaan Zakat </li>
        </ol>
    </nav>

    <div class="my-4 text-right">
        <a href="{{ route('collector.receivement.create') }}" class="btn btn-dark btn-sm">
            Tambah Penerimaan Zakat
            <i class="fa fa-plus"></i>
        </a>
    </div>

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

                <button formaction="{{ route('collector-receivement-report-print.show') }}" class="btn btn-dark btn-sm mr-2">
                    Cetak Laporan Penerimaan
                    <i class="fa fa-print"></i>
                </button>
            </form>
        </div>
    </div>

    <div id="app">
        <receivement-chart/>
    </div>

    <div class="row mt-3 text-center">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <div class="h4 text-primary">
                        Mustahik
                    </div>

                    <div class="font-weight-bold" style="color: #6c7680">
                        {{ \App\Helper\Formatter::number($mustahiqs_count) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <div class="h4 text-primary">
                        Muzaki
                    </div>

                    <div class="font-weight-bold" style="color: #6c7680">
                        {{ \App\Helper\Formatter::number($muzakkis_count) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-arrow-down"></i>
            Penerimaan Zakat
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
                            <th> Muzaki </th>
                            <th> Tanggal Transaksi Terakhir </th>
                            <th class="text-center"> Aksi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($muzakkis as $muzakki)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $muzakki->name }} ({{ $muzakki->NIK }}) </td>
                            <td> {{ \App\Helper\Formatter::date($muzakki->latest_receivement_date) }} </td>
                            <td class="text-center">
                                <a
                                    class="btn btn-dark btn-sm"
                                    href="{{ route("collector-muzakki-receivement.index", $muzakki) }}">
                                    Detail
                                </a>
                            </td>
                        </tr>
                       @endforeach
                   </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@javascript('receivements', $yearly_receivements)
@endsection

@section('script')
    @include('shared.datatables')
@endsection

