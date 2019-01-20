@extends('shared.layout')
@section('title', 'Peta Persebaran UPZ')
@section('content')
<div class="container my-5" id="app">
    <h1 class="mb-5">
        <i class="fa fa-map"></i>
        Peta Persebaran Unit Pengumpulan Zakat
    </h1>

    <guest-map/>
</div>

@javascript('collectors', $collectors)

@endsection