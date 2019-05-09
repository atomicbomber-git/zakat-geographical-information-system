@extends('shared.layout')
@section('title', 'Sunting Data Unit Pengumpulan Zakat')
@section('content')
<div class="container my-5">
    <h1 class="mb-5">
        <i class="fa fa-pencil"></i>
        Sunting Unit Pengumpulan Zakat
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.short_name') }} </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.index') }}">
                    Unit Pengumpulan Zakat
                </a>
            </li>
            <li class="breadcrumb-item active"> Sunting Unit Pengumpulan Zakat </li>
        </ol>
    </nav>

    @include('shared.message', ['session_key' => 'message.success', 'state' => 'success'])

    <div id="app">
        <collector-edit/>
    </div>
</div>

@javascript('collector', $collector)
@javascript('collectors', $collectors)
@javascript('submit_url', route('collector.update', $collector))

@endsection