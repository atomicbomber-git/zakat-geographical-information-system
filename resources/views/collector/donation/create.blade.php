@extends('shared.layout')
@section('title', 'Tambah Pemberian Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Pemberian Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> <a href="{{ route('collector.donation.index') }}"> Pemberian Zakat </a> </li>
            <li class="breadcrumb-item active"> Tambah Pemberian Zakat </li>
        </ol>
    </nav>

    <div id="app">
        <collector-donation-create/>
    </div>
</div>

@javascript('submit_route', route('collector.donation.store'))
@javascript('collector', auth()->user()->collector)
@javascript('collectors', $collectors)
@javascript('default_center', config('gmap_settings.default_center'))

@endsection