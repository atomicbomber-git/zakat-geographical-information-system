@php
    use App\Mustahiq;
@endphp

@extends('shared.layout')
@section('title', 'Pendistribusian Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-arrow-up'></i>
        Daftar Pendistribusian Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> Pendistribusian Zakat </li>
        </ol>
    </nav>

    <div class="my-4 text-right">
        <a href="{{ route('collector.donation.create') }}" class="btn btn-dark btn-sm">
            Tambah Pendistribusian Zakat
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div id="app">
        <donation-chart/>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-arrow-up"></i>
            Daftar Pendistribusian Zakat
        </div>
        <div class="card-body">

            <div class="alert alert-info">
                <strong> Menampilkan laporan pendistribusian zakat untuk tahun {{ $year }} </strong>

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
                             <th> Mustahiq </th>
                             <th> Tanggal Transaksi Terakhir </th>
                             <th class="text-center"> Aksi </th>
                         </tr>
                    </thead>
                    <tbody>
                        @foreach ($mustahiqs as $mustahiq)
                         <tr>
                             <td> {{ $loop->iteration }}. </td>
                             <td> {{ $mustahiq->name }} ({{ $mustahiq->NIK }}) </td>
                             <td> {{ \App\Helper\Formatter::date($mustahiq->latest_donation_date) }} </td>
                             <td class="text-center">
                                 <a
                                     class="btn btn-dark btn-sm"
                                     href="{{ route("collector-mustahiq-donation.index", $mustahiq) }}">
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

@javascript('donations', $yearly_donations)
@endsection

@section('script')
    @include("shared.datatables")
@endsection
