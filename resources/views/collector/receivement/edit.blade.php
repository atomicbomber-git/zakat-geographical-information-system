@extends('shared.layout')
@section('title', 'Sunting Penerimaan Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Sunting Penerimaan Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> <a href="{{ route('collector.receivement.index') }}"> Penerimaan Zakat </a> </li>
            <li class="breadcrumb-item active"> Sunting Penerimaan Zakat </li>
        </ol>
    </nav>

    <div id="app" class="width-md">
        <collector-receivement-edit
            :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
            submit_url="{{ route('collector.receivement.update', $receivement) }}"
            redirect_url="{{ route('collector.receivement.edit', $receivement) }}"
            :muzakkis='{{ json_encode($muzakkis) }}'
            :receivement='{{ json_encode($receivement) }}'
            />
    </div>
</div>

@endsection
