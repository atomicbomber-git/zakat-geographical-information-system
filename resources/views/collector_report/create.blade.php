@extends('shared.layout')
@section('title', 'Tambah Laporan Zakat')
@section('content')
<div class="container mt-5">
    <h1>
        <i class="fa fa-plus"></i>
        Tambah Laporan Zakat
    </h1>

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-plus"></i>
            Tambah Laporan Zakat
        </div>
        <div class="card-body">
            <form action="{{ route('collector.report.store', $collector) }}" method="post">
                @csrf

                <div class='form-group'>
                    <label for='transaction_date'> Tanggal Transaksi: </label>
                
                    <input
                        id='transaction_date' name='transaction_date' type='date'
                        value='{{ old('transaction_date') }}'
                        class='form-control {{ !$errors->has('transaction_date') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('transaction_date') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='amount'> Jumlah: </label>
                
                    <input
                        id='amount' name='amount' type='number'
                        value='{{ old('amount') }}'
                        class='form-control {{ !$errors->has('amount') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('amount') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='type'> Tipe: </label>
                    <select name='type' id='type' class='form-control'>
                        @foreach(\App\Report::TYPES as $key => $value)
                        <option {{ old('type') !== $key ?: 'selected' }} value='{{ $key }}'> {{ $value }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('type') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='note'> Catatan: </label>
                
                    <textarea
                        id='note' name='note'
                        class='form-control {{ !$errors->has('note') ?: 'is-invalid' }}'
                        col='30' row='6'
                        >{{ old('note') }}</textarea>

                    <div class='invalid-feedback'>
                        {{ $errors->first('note') }}
                    </div>
                </div>

                <div class="form-group text-right">
                    <button class="btn btn-primary" type="submit">
                        Tambah Zakat Baru
                        <i class="fa fa-plus"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection