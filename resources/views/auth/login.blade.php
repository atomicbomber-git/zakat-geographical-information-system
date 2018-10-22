@extends('shared.layout')
@section('title', 'Halaman Masuk')
@section('content')
<div class="container mt-5" style="max-width: 30rem">
    <div class="card">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Halaman Masuk Pengguna {{ config('APP_NAME') }}
        </div>
        <div class="card-body">
            <form action="{{ route('login') }}" method="post">
                @csrf
                
                <div class='form-group'>
                    <label for='username'> Username: </label>
                
                    <input
                        id='username' name='username' type='text'
                        value='{{ old('username') }}'
                        placeholder="Username"
                        class='form-control {{ !$errors->has('username') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('username') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='password'> Password: </label>
                
                    <input
                        id='password' name='password' type='password'
                        placeholder="Password"
                        value='{{ old('password') }}'
                        class='form-control {{ !$errors->has('password') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('password') }}
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary">
                        Masuk
                        <i class="fa fa-sign-in"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection