@extends('shared.layout')
@section('title', 'Peta Persebaran UPZ')
@section('content')

<div class="container-fluid mt-3" id="app">
    <guest-map
        :gmap_settings='{{ json_encode(config("gmap_settings")) }}'
        :collectors='{{ json_encode($collectors) }}'
        :kecamatans='{{ json_encode($kecamatans) }}'
        :can_see_muzakkis='{{ json_encode($can_see_muzakkis) }}'
        />
</div>

@endsection
