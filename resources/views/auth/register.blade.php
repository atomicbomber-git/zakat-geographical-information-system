@extends('shared.layout')
@section('title', 'Registrasi')
@section('content')
<div class="container my-5" id="app">
    <h1 class='mb-5'>
        Registrasi
    </h1>

    <register
        submit_url="{{ route('register') }}"
        redirect_url="{{ route('home.show') }}"
        :collectors='{{ json_encode($collectors) }}'
        :config='{{ json_encode(config("gmap_settings")) }}'
        >
    </register>
</div>
@endsection
