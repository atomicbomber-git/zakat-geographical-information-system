@extends('shared.layout')
@section('title', 'Sunting Laporan Penerimaan Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-usd'></i>
        Sunting Laporan Penerimaan Zakat
    </h1>

    <div class="card width-md">
        <div class="card-header">
            <i class="fa fa-usd"></i>
            Sunting Laporan Penerimaan Zakat
        </div>
        <div class="card-body">
            <form method='POST' action='{{ route('report.update', $report) }}'>
                @csrf

                <div class='form-group'>
                    <label for='transaction_date'> Tanggal Transaksi: </label>

                    <input
                        id='transaction_date' name='transaction_date' type='date'
                        placeholder='Tanggal Transaksi'
                        value='{{ old('transaction_date', $report->transaction_date->format('Y-m-d')) }}'
                        class='form-control {{ !$errors->has('transaction_date') ?: 'is-invalid' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('transaction_date') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='zakat'> Zakat: </label>

                    <input
                        id='zakat' name='zakat' type='number'
                        placeholder='Zakat'
                        value='{{ old('zakat', $report->zakat) }}'
                        class='form-control {{ !$errors->has('zakat') ?: 'is-invalid' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('zakat') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='fitrah'> Fitrah: </label>

                    <input
                        id='fitrah' name='fitrah' type='number'
                        placeholder='Fitrah'
                        value='{{ old('fitrah', $report->fitrah) }}'
                        class='form-control {{ !$errors->has('fitrah') ?: 'is-invalid' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('fitrah') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='infak'> Infak: </label>

                    <input
                        id='infak' name='infak' type='number'
                        placeholder='Infak'
                        value='{{ old('infak', $report->infak) }}'
                        class='form-control {{ !$errors->has('infak') ?: 'is-invalid' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('infak') }}
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary">
                        Perbarui Data
                        <i class="fa fa-check"></i>
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>
@endsection
