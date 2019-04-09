@extends('shared.layout')
@section('title', "Detail Penerimaan Zakat UPZ '$collector->name'")
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-list'></i>
        Detail Penerimaan Zakat '{{ $collector->name }}''
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item"> <a href="{{ route('receivement.index', ['year' => $year]) }}"> Penerimaan Zakat </a> </li>
            <li class="breadcrumb-item"> Detail Penerimaan Zakat </li>
        </ol>
    </nav>

    <div id="app">
        <receivement-detailchart/>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Detail Penerimaan Zakat
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-bordered'>
                    <thead class="thead thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Tanggal Transaksi </th>
                            <th> Identitas Pemberi </th>
                            <th class="text-right"> Zakat (Rp.) </th>
                            <th class="text-right"> Fitrah (Rp.) </th>
                            <th class="text-right"> Infak (Rp.) </th>
                            <th class="text-right"> Total (Rp.) </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receivements as $receivement)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $receivement->transaction_date->format('d-m-Y') }} </td>
                            <td>
                                <div> <strong> {{ $receivement->muzakki->name }} </strong> </div>
                                <div> {{ $receivement->muzakki->NIK }} (NIK), {{ $receivement->muzakki->npwz }} (NPWZ) </div>
                                <div> {{ $receivement->muzakki->phone }} (Telp) </div>
                                <div> {{ $receivement->muzakki->gender }} </div>
                                <div> Kecamatan {{ $receivement->muzakki->kecamatan }}, Kelurahan {{ $receivement->muzakki->kelurahan }} </div>
                            </td>
                            <td class="text-right"> {{ number_format($receivement->zakat) }} </td>
                            <td class="text-right"> {{ number_format($receivement->fitrah) }} </td>
                            <td class="text-right"> {{ number_format($receivement->infak) }} </td>
                            <td class="text-right"> {{ number_format($receivement->total) }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"> Total: </td>
                            <td class="text-right"> {{ number_format($receivements->sum('zakat')) }} </td>
                            <td class="text-right"> {{ number_format($receivements->sum('fitrah')) }} </td>
                            <td class="text-right"> {{ number_format($receivements->sum('infak')) }} </td>
                            <td class="text-right"> {{ number_format($receivements->sum('total')) }} </td>
                        </tr>
                    </tfoot>
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