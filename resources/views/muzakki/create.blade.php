@extends('shared.layout')
@section('title', 'Tambah Muzaki')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Muzaki
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href=""> SIG Zakat </a> </li>
            <li class="breadcrumb-item">
                UPZ {{ $collector->name }}
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.muzakki.index', $collector) }}">
                    Muzaki
                </a>
            </li>
            <li class="breadcrumb-item active">
                Tambah Muzaki
            </li>
        </ol>
    </nav>

    <div id="app">
        <collector-muzakki-create
            :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
            submit_url='{{ route("collector.muzakki.store", $collector) }}'
            redirect_url='{{ route("collector.muzakki.index", $collector) }}'
            :collector='{{ json_encode($collector) }}'
            :original_muzakkis='{{ json_encode($muzakkis) }}'
            datasource_url="{{ asset(config('app.datasource_publicpath')) }}"
            />
    </div>
</div>
@endsection
