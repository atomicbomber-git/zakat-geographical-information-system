@extends('shared.layout')
@section('title', 'Tambah Muzakki')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Muzakki
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href=""> SIG Zakat </a> </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.muzakki.index') }}">
                    Muzakki
                </a>
            </li>
            <li class="breadcrumb-item active">
                Tambah Muzakki
            </li>
        </ol>
    </nav>

    <div id="app">
        <collector-muzakki-create
            :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
            submit_url='{{ route("collector.muzakki.store") }}'
            redirect_url='{{ route("collector.muzakki.index") }}'
            :collector='{{ json_encode($collector) }}'
            :original_muzakkis='{{ json_encode($muzakkis) }}'
            />
    </div>
</div>
@endsection