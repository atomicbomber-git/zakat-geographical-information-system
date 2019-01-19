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

<script>
    window.collectors = []

    @foreach ($collectors as $collector)
    collectors.push({
        id: {{ $collector->id }},
        latitude: {{ $collector->latitude }},
        longitude: {{ $collector->longitude }},
        name: '{{ $collector->name }}',
        address: `{{ $collector->address }}`,
        imageUrl: '{{ route('collector.thumbnail', $collector) . "?" . rand() }}'
    })
    @endforeach
</script>

@javascript('receivers', $receivers)

@javascript('receivers_count', $receivers->count())
@javascript('collectors_count', $collectors->count())

@endsection