@extends('shared.layout')
@section('title', 'Sunting Mustahik')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Mustahik
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href=""> SIG Zakat </a> </li>
            <li class="breadcrumb-item"> UPZ {{ $collector->name }} </a> </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.mustahiq.index', $collector) }}">
                    Mustahik
                </a>
            </li>
            <li class="breadcrumb-item active">
                Sunting Mustahik
            </li>
        </ol>
    </nav>

    <div id="app">
        <collector-mustahiq-edit
            :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
            submit_url='{{ route("collector.mustahiq.update", $mustahiq) }}'
            redirect_url='{{ route("collector.mustahiq.index", $collector) }}'
            :collector='{{ json_encode($collector) }}'
            :mustahiq='{{ json_encode($mustahiq) }}'
            :original_mustahiqs='{{ json_encode($mustahiqs) }}'
            datasource_url="{{ asset(config('app.datasource_publicpath')) }}"
            :program_bantuan_types="{{ json_encode(\App\Mustahiq::PROGRAM_BANTUAN_TYPES) }}"
            />
    </div>
</div>
@endsection
