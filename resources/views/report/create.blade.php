@extends('shared.layout')
@section('title', 'Tambah Laporan Penerimaan Zakat')
@section('content')
<div class="container mt-5">
    <h1 class="mb-5">
        <i class="fa fa-plus"></i>
        Tambah Laporan Penerimaan Zakat
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item"> <a href="{{ route("report.index") }}"> Penerimaan Zakat </a> </li>
            <li class="breadcrumb-item active">
                Tambah Laporan Penerimaan Zakat
            </li>
        </ol>
    </nav>

    <div class="card width-md mb-5">
        <div class="card-header">
            <i class="fa fa-money"></i>
            Tambah Laporan Penerimaan Zakat
        </div>
        <div class="card-body">
            <form method='POST' action='{{ route('report.store') }}'>
                @csrf

                <div class='form-group'>
                    <label for='transaction_date'>
                         Tanggal Transaksi:
                    </label>

                    <input
                        id='transaction_date'
                        name='transaction_date'
                        type='date'
                        placeholder='Tanggal Transaksi'
                        value='{{ old('transaction_date') }}'
                        class='form-control {{ $errors->has('transaction_date') ? 'is-invalid' : '' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('transaction_date') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='zakat'>
                         Zakat Mal:
                    </label>

                    <input
                        id='zakat'
                        name='zakat'
                        type='number'
                        placeholder='Zakat Mal'
                        value='{{ old('zakat') }}'
                        class='form-control {{ $errors->has('zakat') ? 'is-invalid' : '' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('zakat') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='fitrah'>
                         Zakat Fitrah Tunai:
                    </label>

                    <input
                        id='fitrah'
                        name='fitrah'
                        type='number'
                        placeholder='Zakat Fitrah Tunai'
                        value='{{ old('fitrah') }}'
                        class='form-control {{ $errors->has('fitrah') ? 'is-invalid' : '' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('fitrah') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='fitrah_beras'>
                         Zakat Fitrah Beras:
                    </label>

                    <input
                        id='fitrah_beras'
                        name='fitrah_beras'
                        type='text'
                        placeholder='Zakat Fitrah Beras'
                        value='{{ old('fitrah_beras') }}'
                        class='form-control {{ $errors->has('fitrah_beras') ? 'is-invalid' : '' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('fitrah_beras') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='infak'>
                         Infak:
                    </label>

                    <input
                        id='infak'
                        name='infak'
                        type='number'
                        placeholder='Infak'
                        value='{{ old('infak') }}'
                        class='form-control {{ $errors->has('infak') ? 'is-invalid' : '' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('infak') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='sedekah'>
                         Sedekah:
                    </label>

                    <input
                        id='sedekah'
                        name='sedekah'
                        type='number'
                        placeholder='Sedekah'
                        value='{{ old('sedekah') }}'
                        class='form-control {{ $errors->has('sedekah') ? 'is-invalid' : '' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('sedekah') }}
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary">
                        Tambah Laporan Penerimaan Zakat
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
