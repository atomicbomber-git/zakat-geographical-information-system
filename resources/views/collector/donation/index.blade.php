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
                <table class='table table-sm table-bordered table-striped'>
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Tanggal Transaksi </th>
                            <th> Identitas Penerima </th>
                            <th> asnaf </th>
                            <th> Program Bantuan </th>
                            <th class="text-right"> Jumlah Zakat (Rp.) </th>
                            <th class="text-center"> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donations as $donation)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $donation->transaction_date->format('d-m-Y') }} </td>
                            <td>
                                <div> <strong> {{ $donation->mustahiq->name }} </strong> </div>
                                <div> {{ $donation->mustahiq->nik }} (NIK) </div>
                                <div> {{ Mustahiq::GENDERS[$donation->mustahiq->gender] }}, {{ $donation->occupation }} </div>
                                <div> {{ $donation->mustahiq->phone }} (Telp.) </div>
                                <div> {{ $donation->mustahiq->address }} </div>
                                <div> Kecamatan {{ $donation->mustahiq->kecamatan }}, Kelurahan {{ $donation->mustahiq->kelurahan }} </div>
                            </td>
                            <td> {{ $donation->mustahiq->asnaf }} </td>
                            <td> {{ $donation->mustahiq->help_program }} </td>
                            <td class="text-right"> {{ number_format($donation->amount) }} </td>
                            <td class="text-center">
                                <a href="{{ route('collector.donation.edit', $donation) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form class="form-delete d-inline-block" action='{{ route('collector.donation.delete', $donation) }}' method='POST'>
                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right"> Total: </td>
                            <td class="text-right"> {{ number_format($donations->sum('amount')) }} </td>
                            <td></td>
                        </tr>
                    </tfoot>
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
