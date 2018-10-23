@extends('shared.layout')
@section('title', 'Sunting Data Unit Pengumpulan Zakat')
@section('content')
<div class="container my-5">
    <h1>
        <i class="fa fa-pencil"></i>
        Sunting Data Unit Pengumpulan Zakat
    </h1>

    <div class="row">
        <div class="col-5">
            <div class="card mt-5">
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    Sunting Data Unit Pengumpulan Zakat
                </div>
                <div class="card-body">
                    <form action="{{ route('collector.update', $collector) }}" method="POST">
                        @csrf

                        <h3> Data Unit Pengumpul Zakat </h3>
                        <hr>

                        <div class='form-group'>
                            <label for='collector_name'> Nama Unit: </label>
                        
                            <input
                                id='collector_name' name='collector_name' type='text'
                                value='{{ old('collector_name', $collector->name) }}'
                                class='form-control {{ !$errors->has('collector_name') ?: 'is-invalid' }}'>
                        
                            <div class='invalid-feedback'>
                                {{ $errors->first('collector_name') }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='npwz'> NPWZ: </label>
                        
                            <input
                                id='npwz' name='npwz' type='text'
                                value='{{ old('npwz', $collector->npwz) }}'
                                class='form-control {{ !$errors->has('npwz') ?: 'is-invalid' }}'>
                        
                            <div class='invalid-feedback'>
                                {{ $errors->first('npwz') }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='address'> Alamat: </label>
                        
                            <textarea
                                id='address' name='address'
                                class='form-control {{ !$errors->has('address') ?: 'is-invalid' }}'
                                col='30' row='6'
                                >{{ old('address', $collector->address) }}</textarea>
                        
                            <div class='invalid-feedback'>
                                {{ $errors->first('address') }}
                            </div>
                        </div>

                        <h3 class="mt-3"> Data Akun Administrator </h3>
                        <hr>

                        <div class='form-group'>
                            <label for='user_name'> Nama Administrator: </label>
                        
                            <input
                                id='user_name' name='user_name' type='text'
                                value='{{ old('user_name', $collector->user->name) }}'
                                class='form-control {{ !$errors->has('user_name') ?: 'is-invalid' }}'>
                        
                            <div class='invalid-feedback'>
                                {{ $errors->first('user_name') }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='username'> Username: </label>
                        
                            <input
                                id='username' name='username' type='text'
                                value='{{ old('username', $collector->user->username) }}'
                                class='form-control {{ !$errors->has('username') ?: 'is-invalid' }}'>
                        
                            <div class='invalid-feedback'>
                                {{ $errors->first('username') }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='password'> Password: </label>
                        
                            <input
                                placeholder="Kata sandi"
                                id='password' name='password' type='password'
                                value='{{ old('password') }}'
                                class='form-control {{ !$errors->has('password') ?: 'is-invalid' }}'>
                        
                            <div class='invalid-feedback'>
                                {{ $errors->first('password') }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='password_confirmation'> Ulangi Password: </label>
                        
                            <input
                                placeholder="Ulangi kata sandi"
                                id='password_confirmation' name='password_confirmation' type='password'
                                value='{{ old('password_confirmation') }}'
                                class='form-control {{ !$errors->has('password_confirmation') ?: 'is-invalid' }}'>
                        
                            <div class='invalid-feedback'>
                                {{ $errors->first('password_confirmation') }}
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
    </div>
</div>
@endsection