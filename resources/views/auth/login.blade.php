@extends('shared.layout')
@section('title', 'Halaman Masuk')
@section('content')

<div class="d-flex align-items-center" style="height: 90vh; background-image: url({{ asset(config('app.login_image')) }}); background-size: cover">
    <div class="container" style="max-width: 30rem">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-list"></i>
                Halaman Masuk Pengguna {{ config('APP_NAME') }}
            </div>
            <div class="card-body">
                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <div class='form-group'>
                        <label for='username'> Nama Pengguna: </label>

                        <input
                            id='username' name='username' type='text'
                            value='{{ old('username') }}'
                            placeholder="Nama Pengguna"
                            class='form-control {{ !$errors->has('username') ?: 'is-invalid' }}'>

                        <div class='invalid-feedback'>
                            {{ $errors->first('username') }}
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='password'> Kata Sandi: </label>

                        <input
                            id='password' name='password' type='password'
                            placeholder="Kata Sandi"
                            value='{{ old('password') }}'
                            class='form-control {{ !$errors->has('password') ?: 'is-invalid' }}'>

                        <div class='invalid-feedback'>
                            {{ $errors->first('password') }}
                        </div>
                    </div>

                    <div class="text-right">
                        <a
                            class="btn btn-default"
                            href="{{ route('register') }}"
                            >
                            <i class="fa fa-sign-up"></i>
                            Registrasi
                        </a>

                        <button class="btn btn-primary">
                            Masuk
                            <i class="fa fa-sign-in"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
