@extends('shared.layout')
@section('title', 'Sunting Pemberian Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Pemberian Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> <a href="{{ route('collector.donation.index') }}"> Pemberian Zakat </a> </li>
            <li class="breadcrumb-item active"> Sunting Pemberian Zakat </li>
        </ol>
    </nav>

    <div id="app">
        <collector-donation-edit/>
    </div>
</div>

@javascript('submit_route', route('collector.donation.update', $donation))
@javascript('collectors', $collectors)
@javascript('donation', $donation)

@endsection