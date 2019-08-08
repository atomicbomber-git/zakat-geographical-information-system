@extends('shared.layout')
@section('title', 'Peta Persebaran UPZ')
@section('content')

<div class="d-flex justify-content-center my-4 front-secondary">
    <img
        class="img-fluid"
        src="{{ asset('image/front.jpeg') }}"
        alt="Front Image">
</div>

<div class="container-fluid my-5" id="app">
    @include("shared.auth-info")

    <h1 class="h3 mx-5 my-5">
        Assalammualaikum, Selamat Datang di "Sistem Informasi Zakat"

        <p class="lead">
            {{ $description_text }}
        </p>
    </h1>

    <guest-map
        :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
        :collectors='{{ json_encode($collectors) }}'
        :kecamatans='{{ json_encode($kecamatans) }}'
        :can_see_muzakkis='{{ json_encode($can_see_muzakkis) }}'
        />
</div>

@section('pre-footer')
<div class="front-secondary">
    <div class="container py-3">

        <h2 class="h2 text-dark text-center mb-4">
            Statistik Saat Ini
        </h2>

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner text-center">
                <div class="carousel-item active">
                    <img class="d-block mx-auto mb-3 rounded-circle" style="width: 150px; height: 150px;" src="{{ asset("image/muzakki.jpeg") }}" alt="Gambar Muzakki">
                    <h3> Muzakki </h3>
                    <span> {{ $muzakkis_count }} </span>
                </div>
                <div class="carousel-item">
                    <img class="d-block mx-auto mb-3 rounded-circle" style="width: 150px; height: 150px;" src="{{ asset("image/upz.jpeg") }}" alt="Gambar UPZ">
                    <h3> UPZ </h3>
                    <span> {{ $collectors->count() }} </span>
                </div>
                <div class="carousel-item">
                    <img class="d-block mx-auto mb-3 rounded-circle" style="width: 150px; height: 150px;" src="{{ asset("image/mustahiq.jpeg") }}" alt="Gambar Mustahiq">
                    <h3> Mustahiq </h3>
                    <span> {{ $mustahiqs_count }} </span>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
@endsection

@endsection
