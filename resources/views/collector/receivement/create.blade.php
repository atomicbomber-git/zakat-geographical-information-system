@extends('shared.layout')
@section('title', 'Tambah Penerimaan Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Penerimaan Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> <a href="{{ route('collector.receivement.index') }}"> Penerimaan Zakat </a> </li>
            <li class="breadcrumb-item active"> Tambah Penerimaan Zakat </li>
        </ol>
    </nav>

    <div id="app">
        <collector-receivement-create
            :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
            submit_url="{{ route('collector.receivement.store') }}"
            redirect_url="{{ route('collector.receivement.index') }}"
            :muzakkis='{{ json_encode($muzakkis) }}'
            />
    </div>
</div>

@endsection