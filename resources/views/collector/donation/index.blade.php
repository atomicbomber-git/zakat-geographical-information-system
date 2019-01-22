@extends('shared.layout')
@section('title', 'Pemberian Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-arrow-up'></i>
        Daftar Pemberian Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> Pemberian Zakat </li>
        </ol>
    </nav>

    <div class="my-4 text-right">
        <a href="{{ route('collector.donation.create') }}" class="btn btn-dark btn-sm">
            Tambah Pemberian Zakat
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div id="app">
        <donation-chart/>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-arrow-up"></i>
            Daftar Pemberian Zakat
        </div>
        <div class="card-body">

            <div class="alert alert-info">
                <strong> Menampilkan laporan pemberian zakat untuk tahun {{ $year }} </strong>

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
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Tanggal Transaksi </th>
                            <th> Identitas Penerima </th>
                            <th> Ansaf </th>
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
                                <div> <strong> {{ $donation->name }} </strong> </div>
                                <div> {{ $donation->nik }} (NIK) </div>
                                <div> {{ $donation->gender }}, {{ $donation->occupation }} </div>
                                <div> {{ $donation->phone }} (Telp.) </div>
                                <div> {{ $donation->address }} </div>
                                <div> Kecamatan {{ $donation->kecamatan }}, Kelurahan {{ $donation->kelurahan }} </div>
                            </td>
                            <td> {{ $donation->ansaf }} </td>
                            <td> {{ $donation->help_program }} </td>
                            <td class="text-right"> {{ number_format($donation->amount) }} </td>
                            <td class="text-center">
                                <a href="{{ route('collector.donation.edit', $donation) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action='{{ route('collector.donation.delete', $donation) }}' method='POST' class='d-inline-block'>
                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-right"> Total: </td>
                            <td class="text-right"> {{ number_format($donations->sum('amount')) }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@javascript('donations', $yearly_donations)
@endsection