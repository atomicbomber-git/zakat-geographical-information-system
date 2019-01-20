@extends('shared.layout')
@section('title', 'Sunting Data Unit Pengumpulan Zakat')
@section('content')
<div class="container my-5">
    <h1 class="mb-5">
        <i class="fa fa-pencil"></i>
        Sunting Data Unit Pengumpulan Zakat
    </h1>

    <div id="app">
        <collector-edit/>
    </div>
</div>

@javascript('collector', $collector)
@javascript('collectors', $collectors)
@javascript('submit_url', route('collector.update', $collector))

@endsection