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
                            <th> UPZ </th>
                            <th class="text-right"> Zakat (Rp.) </th>
                            <th class="text-right"> Fitrah (Rp.) </th>
                            <th class="text-right"> Infak (Rp.) </th>
                            <th class="text-right"> Total </th>
                            <th class="text-center"> Aksi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($collectors as $collector)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $collector->name }} </td>
                            <td class="text-right"> {{ number_format($collector->receivement['zakat']) }} </td>
                            <td class="text-right"> {{ number_format($collector->receivement['fitrah']) }} </td>
                            <td class="text-right"> {{ number_format($collector->receivement['infak']) }} </td>
                            <td class="text-right"> {{ number_format($collector->receivement['subtotal']) }} </td>
                            <td class="text-center">
                                <a href="{{ route('receivement.detail', ['collector' => $collector, 'year' => $year]) }}" class="btn btn-dark btn-sm">
                                    Detail
                                    <i class="fa fa-list"></i>
                                </a>
                            </td>
                        </tr>
                       @endforeach
                       <tr>
                           <td></td>
                           <td class="text-right"> Total: </td>
                           <td class="text-right"> {{ number_format($collectors->sum('receivement.zakat')) }} </td>
                           <td class="text-right"> {{ number_format($collectors->sum('receivement.fitrah')) }} </td>
                           <td class="text-right"> {{ number_format($collectors->sum('receivement.infak')) }} </td>
                           <td class="text-right"> {{ number_format($collectors->sum('receivement.subtotal')) }} </td>
                           <td></td>
                       </tr>
                   </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection