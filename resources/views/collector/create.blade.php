@extends('shared.layout')
@section('title', 'Tambah Unit Pengumpul Zakat')
@section('content')
<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fa fa-plus"></i>
        Tambah Unit Pengumpul Zakat
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.short_name') }} </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.index') }}">
                    Unit Pengumpul Zakat
                </a>
            </li>
            <li class="breadcrumb-item active">
                Tambah Unit Pengumpul Zakat
            </li>
        </ol>
    </nav>

    <div id="app">
        <collector-create
            submit_url="{{ route('collector.store') }}"
            redirect_url="{{ route('collector.index') }}"
            :collectors='{{ json_encode($collectors) }}'
            :config='{{ json_encode(config("gmap_settings")) }}'
            datasource_url="{{ asset(config('app.datasource_publicpath')) }}"
            >
        </collector-create>
    </div>
</div>
@endsection
