@extends('shared.layout')
@section('title', "Detail Pemberian Zakat UPZ '$collector->name'")
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-list'></i>
        Detail Pemberian Zakat '{{ $collector->name }}''
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item"> <a href="{{ route('donation.index', ['year' => $year]) }}"> Pemberian Zakat </a> </li>
            <li class="breadcrumb-item"> Detail Pemberian Zakat </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Detail Pemberian Zakat
        </div>

        <div class="card-body">
            <table class='table table-sm table-bordered'>
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Tanggal Transaksi </th>
                        <th> Identitas Penerima </th>
                        <th> Ansaf </th>
                        <th> Program Bantuan </th>
                        <th class="text-right"> Jumlah Zakat (Rp.) </th>
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
@endsection