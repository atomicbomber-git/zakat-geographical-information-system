@extends('shared.layout')
@section('title', 'Sunting Data Laporan Penerimaan Zakat')
@section('content')
<div class="container my-5">
    <h1 class="mb-5">
        <i class="fa fa-pencil"></i>
        Sunting Data Laporan Penerimaan Zakat
    </h1>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            Sunting Data Laporan Penerimaan Zakat
        </div>
        <div class="card-body">
            <form action="{{ route('collector.report.update', $report) }}" method="post">
                @csrf

                <div class='form-group'>
                    <label for='transaction_date'> Tanggal Transaksi: </label>
                
                    <input
                        id='transaction_date' name='transaction_date' type='date'
                        value='{{ old('transaction_date', $report->transaction_date) }}'
                        class='form-control {{ !$errors->has('transaction_date') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('transaction_date') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='zakat'> Zakat: </label>
                
                    <input
                        id='zakat' name='zakat' type='number'
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
                        value='{{ old('infak', $report->infak) }}'
                        class='form-control {{ !$errors->has('infak') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('infak') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='note'> Catatan: </label>
                
                    <textarea
                        id='note' name='note'
                        class='form-control {{ !$errors->has('note') ?: 'is-invalid' }}'
                        col='30' row='6'
                        >{{ old('note', $report->note) }}</textarea>

                    <div class='invalid-feedback'>
                        {{ $errors->first('note') }}
                    </div>
                </div>

                <div class="form-group text-right">
                    <button class="btn btn-primary" type="submit">
                        Perbarui
                        <i class="fa fa-check"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection