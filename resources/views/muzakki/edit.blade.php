@extends('shared.layout')
@section('title', 'Sunting Muzakki')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Muzakki
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href=""> SIG Zakat </a> </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.muzakki.index') }}">
                    Muzakki
                </a>
            </li>
            <li class="breadcrumb-item active">
                Sunting Muzakki
            </li>
        </ol>
    </nav>

    <div id="app">
        <collector-muzakki-edit
            :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
            submit_url='{{ route("collector.muzakki.update", $muzakki) }}'
            redirect_url='{{ route("collector.muzakki.index") }}'
            :collector='{{ json_encode($collector) }}'
            :muzakki='{{ json_encode($muzakki) }}'
            :original_muzakkis='{{ json_encode($muzakkis) }}'
            datasource_url="{{ asset(config('app.datasource_publicpath')) }}"
            />
    </div>
</div>
@endsection
