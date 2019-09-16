@extends('shared.layout')
@section('title', 'Sunting Pendistribusian Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Pendistribusian Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> <a href="{{ route('collector.donation.index') }}"> Pendistribusian Zakat </a> </li>
            <li class="breadcrumb-item active"> Sunting Pendistribusian Zakat </li>
        </ol>
    </nav>

    <div id="app" class="width-md">
        <collector-donation-edit
            :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
            submit_url="{{ route('collector.donation.update', $donation) }}"
            redirect_url="{{ route('collector.donation.edit', $donation) }}"
            :mustahiqs='{{ json_encode($mustahiqs) }}'
            :donation='{{ json_encode($donation) }}'
            />
    </div>
</div>
@endsection
