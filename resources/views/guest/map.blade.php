@extends('shared.layout')
@section('title', 'Peta Persebaran UPZ')
@section('content')
<div class="container my-5">
    <h1 class="mb-5">
        <i class="fa fa-map"></i>
        Peta Persebaran Unit Pengumpulan Zakat
    </h1>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-map"></i>
            Peta Persebaran Unit Pengumpulan Zakat
        </div>
        <div class="card-body">
            <div id="app">
                <guest-map/>
            </div>
        </div>
    </div>
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

@endsection