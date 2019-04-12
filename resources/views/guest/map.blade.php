@extends('shared.layout')
@section('title', 'Peta Persebaran UPZ')
@section('content')
<div class="container my-5" id="app">
    <h1 class="mb-5">
        <i class="fa fa-map"></i>
        Peta Persebaran Unit Pengumpulan Zakat
    </h1>


    <guest-map
        :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
        :collectors='{{ json_encode($collectors) }}'
        />
</div>

@section('pre-footer')
<div style="background: #b5ffb4">
    <div class="container py-3">

        <h2 class="h2 text-dark text-center mb-4"> 
            Statistik Saat Ini
        </h2>

        <div class="row text-dark">
            <div class="col-md-4 text-center">
                <img class="d-block mx-auto mb-3 rounded-circle" style="width: 150px; height: 150px;" src="{{ asset("image/muzakki.jpeg") }}" alt="Gambar Muzakki">
                <h3> Muzakki </h3>
                <span> {{ $muzakkis_count }} </span>
            </div>
            <div class="col-md-4 text-center">
                <img class="d-block mx-auto mb-3 rounded-circle" style="width: 150px; height: 150px;" src="{{ asset("image/upz.jpeg") }}" alt="Gambar UPZ">
                <h3> UPZ </h3>
                <span> {{ $collectors->count() }} </span>
            </div>
            <div class="col-md-4 text-center">
                <img class="d-block mx-auto mb-3 rounded-circle" style="width: 150px; height: 150px;" src="{{ asset("image/mustahiq.jpeg") }}" alt="Gambar Mustahiq">
                <h3> Mustahiq </h3>
                <span> {{ $mustahiqs_count }} </span>
            </div>
        </div>
    </div>
</div>
@endsection

@endsection