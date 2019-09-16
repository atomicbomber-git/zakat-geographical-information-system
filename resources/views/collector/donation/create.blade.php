@extends('shared.layout')
@section('title', 'Tambah Pendistribusian Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Pendistribusian Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> <a href="{{ route('collector.donation.index') }}"> Pendistribusian Zakat </a> </li>
            <li class="breadcrumb-item active"> Tambah Pendistribusian Zakat </li>
        </ol>
    </nav>

    <div id="app" class="width-md">
        <collector-donation-create
            :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
            submit_url="{{ route('collector.donation.store') }}"
            redirect_url="{{ route('collector.donation.index') }}"
            :mustahiqs='{{ json_encode($mustahiqs) }}'
            />
    </div>
</div>

@endsection
