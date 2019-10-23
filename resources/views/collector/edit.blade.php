@extends('shared.layout')
@section('title', 'Sunting Data Unit Pengumpul Zakat')
@section('content')
<div class="container my-5">
    <h1 class="mb-5">
        <i class="fa fa-pencil"></i>
        Sunting Unit Pengumpul Zakat
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.short_name') }} </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.index') }}">
                    Unit Pengumpul Zakat
                </a>
            </li>
            <li class="breadcrumb-item active"> Sunting Unit Pengumpul Zakat </li>
        </ol>
    </nav>

    @include('shared.message', ['session_key' => 'message.success', 'state' => 'success'])

    <div id="app">
        <collector-edit
            submit_url="{{ route('collector.update', $collector) }}"
            redirect_url="{{ route('collector.edit', $collector) }}"
            :collectors='{{ json_encode($collectors) }}'
            :collector='{{ json_encode($collector) }}'
            :config='{{ json_encode(config("gmap_settings")) }}'
            datasource_url="{{ asset(config('app.datasource_publicpath')) }}"
            >

        </collector-edit>
    </div>
</div>

@javascript('collector', $collector)
@javascript('collectors', $collectors)
@javascript('submit_url', route('collector.update', $collector))

@endsection
