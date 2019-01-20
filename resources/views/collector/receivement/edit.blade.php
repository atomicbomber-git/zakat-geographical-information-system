@extends('shared.layout')
@section('title', 'Sunting Penerimaan Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Penerimaan Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item"> <a href="{{ route('collector.receivement.index') }}"> Penerimaan Zakat </a> </li>
            <li class="breadcrumb-item active"> Sunting Penerimaan Zakat </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            Sunting Penerimaan Zakat
        </div>
        <div class="card-body">
            <form action="{{ route('collector.receivement.update', $receivement) }}" method="POST">
                @csrf
                <h4> Identitas Pemberi Zakat </h4>
                <hr class="mt-0">
    
                <div class='form-group'>
                    <label for='name'> Nama Pemberi: </label>
                
                    <input
                        id='name' name='name' type='text'
                        placeholder='Nama Pemberi'
                        value='{{ old('name', $receivement->name) }}'
                        class='form-control {{ !$errors->has('name') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('name') }}
                    </div>
                </div>
    
                <div class='form-group'>
                    <label for='gender'> Jenis Kelamin: </label>
                    <select name='gender' id='gender' class='form-control'>
                        @foreach(\App\Receivement::GENDERS as $key => $value)
                        <option {{ old('gender', $receivement->gender) !== $key ?: 'selected' }} value='{{ $key }}'> {{ $value }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('gender') }}
                    </div>
                </div>
    
                <div class='form-group'>
                    <label for='NIK'> NIK: </label>
                
                    <input
                        id='NIK' name='NIK' type='text'
                        placeholder='NIK'
                        value='{{ old('NIK', $receivement->NIK) }}'
                        class='form-control {{ !$errors->has('NIK') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('NIK') }}
                    </div>
                </div>
    
                <div class='form-group'>
                    <label for='kecamatan'> Kecamatan: </label>
                
                    <input
                        id='kecamatan' name='kecamatan' type='text'
                        placeholder='Kecamatan'
                        value='{{ old('kecamatan', $receivement->kecamatan) }}'
                        class='form-control {{ !$errors->has('kecamatan') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('kecamatan') }}
                    </div>
                </div>
    
                <div class='form-group'>
                    <label for='kelurahan'> Kelurahan: </label>
                
                    <input
                        id='kelurahan' name='kelurahan' type='text'
                        placeholder='Kelurahan'
                        value='{{ old('kelurahan', $receivement->kelurahan) }}'
                        class='form-control {{ !$errors->has('kelurahan') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('kelurahan') }}
                    </div>
                </div>

                <div class='form-group'>
                        <label for='npwz'> NPWZ: </label>
                    
                        <input
                            id='npwz' name='npwz' type='text'
                            placeholder='NPWZ'
                            value='{{ old('npwz', $receivement->npwz) }}'
                            class='form-control {{ !$errors->has('npwz') ?: 'is-invalid' }}'>
                    
                        <div class='invalid-feedback'>
                            {{ $errors->first('npwz') }}
                        </div>
                    </div>
    
                    <div class='form-group'>
                        <label for='phone'> No. Telefon: </label>
                    
                        <input
                            id='phone' name='phone' type='phone'
                            placeholder='No. Telefon'
                            value='{{ old('phone', $receivement->phone) }}'
                            class='form-control {{ !$errors->has('phone') ?: 'is-invalid' }}'>
                    
                        <div class='invalid-feedback'>
                            {{ $errors->first('phone') }}
                        </div>
                    </div>
    
                <h4 class="mt-5"> Informasi Zakat </h4>
                <hr class="mt-0">
    
                <div class='form-group'>
                    <label for='transaction_date'> Tanggal Transaksi: </label>
                
                    <input
                        id='transaction_date' name='transaction_date' type='date'
                        placeholder='Tanggal Transaksi'
                        value='{{ old('transaction_date', $receivement->transaction_date->format('Y-m-d')) }}'
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
                        value='{{ old('zakat', $receivement->zakat) }}'
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
                        value='{{ old('fitrah', $receivement->fitrah) }}'
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
                        value='{{ old('infak', $receivement->infak) }}'
                        class='form-control {{ !$errors->has('infak') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('infak') }}
                    </div>
                </div>
    
                <div class="form-group text-right">
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