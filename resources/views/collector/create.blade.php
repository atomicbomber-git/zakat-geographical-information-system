@extends('shared.layout')
@section('title', 'Tambah Unit Pengumpulan Zakat')
@section('content')
<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fa fa-plus"></i>
        Tambah Unit Pengumpulan Zakat
    </h1>

    <div id="app">
        <collector-create
            submit_url="{{ route('collector.store') }}"
            redirect_url="{{ route('collector.index') }}"
            :collectors='{{ json_encode($collectors) }}'
            :config='{{ json_encode(config("gmap_settings")) }}'
            >
        </collector-create>
    </div>
</div>
@endsection
