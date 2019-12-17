@extends('shared.layout')
@section('title', 'Tambah Mustahik')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Mustahik
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href=""> SIG Zakat </a> </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.mustahiq.index') }}">
                    Mustahik
                </a>
            </li>
            <li class="breadcrumb-item active">
                Tambah Mustahik
            </li>
        </ol>
    </nav>

    <div id="app">
        <collector-mustahiq-create
            :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
            submit_url='{{ route("collector.mustahiq.store") }}'
            redirect_url='{{ route("collector.mustahiq.index") }}'
            :collector='{{ json_encode($collector) }}'
            :original_mustahiqs='{{ json_encode($mustahiqs) }}'
            datasource_url="{{ asset(config('app.datasource_publicpath')) }}"
            :program_bantuan_types="{{ json_encode(\App\Mustahiq::PROGRAM_BANTUAN_TYPES) }}"
            />
    </div>
</div>
@endsection
