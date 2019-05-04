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

    <div id="app">
        <receivement-chart/>
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
                            <th> Tanggal Transaksi </th>
                            <th> Identitas Pemberi </th>
                            <th class="text-right"> Zakat (Rp.) </th>
                            <th class="text-right"> Fitrah (Rp.) </th>
                            <th class="text-right"> Infak (Rp.) </th>
                            <th class="text-right"> Total (Rp.) </th>
                            <th class="text-center"> Aksi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($receivements as $receivement)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $receivement->transaction_date->format('d-m-Y') }} </td>
                            <td>
                                @isset($receivement->muzakki)

                                <div> <strong> {{ $receivement->muzakki->name }} </strong> </div>
                                <div> {{ $receivement->muzakki->NIK }} (NIK), {{ $receivement->muzakki->npwz }} (NPWZ) </div>
                                <div> {{ $receivement->muzakki->phone }} (Telp) </div>
                                <div> {{ $receivement->muzakki->gender }} </div>
                                <div> Kecamatan {{ $receivement->muzakki->kecamatan }}, Kelurahan {{ $receivement->muzakki->kelurahan }} </div>

                                @else
                                    -
                                @endisset
                            </td>
                            <td class="text-right"> {{ number_format($receivement->zakat) }} </td>
                            <td class="text-right"> {{ number_format($receivement->fitrah) }} </td>
                            <td class="text-right"> {{ number_format($receivement->infak) }} </td>
                            <td class="text-right"> {{ number_format($receivement->total) }} </td>
                            <th class="text-center">
                                <a href="{{ route('collector.receivement.edit', $receivement) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                
                                <form class="form-delete d-inline-block" action='{{ route('collector.receivement.delete', $receivement) }}' method='POST'>
                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                            </th>
                        </tr>
                       @endforeach
                       <tr>
                           <td colspan="3" class="text-right"> Total: </td>
                           <td class="text-right"> {{ number_format($receivements->sum('zakat')) }} </td>
                           <td class="text-right"> {{ number_format($receivements->sum('fitrah')) }} </td>
                           <td class="text-right"> {{ number_format($receivements->sum('infak')) }} </td>
                           <td class="text-right"> {{ number_format($receivements->sum('total')) }} </td>
                           <td> </td>
                       </tr>
                   </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@javascript('receivements', $yearly_receivements)
@endsection