@extends('shared.layout')
@section('title', 'Tambah Mustahiq')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Mustahiq
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href=""> SIG Zakat </a> </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.mustahiq.index') }}">
                    Mustahiq
                </a>
            </li>
            <li class="breadcrumb-item active">
                Tambah Mustahiq
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
            />
    </div>
</div>
@endsection