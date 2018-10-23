@extends('shared.layout')
@section('title', 'Tambah Unit Pengumpulan Zakat')
@section('content')
<div class="container mt-5">
    
    <script>
        window.submit_url='{{ route('collector.store') }}'
        window.def_lat=-0.026330
        window.def_lng=109.342504

        window.collectors = []

        @foreach ($collectors as $collector)
        window.collectors.push({
            id: {{ $collector->id }},
            name: '{{ $collector->name }}',
            address: `{{ $collector->address }}`,
            latitude: {{ $collector->latitude }},
            longitude: {{ $collector->longitude }}
        })
        @endforeach

    </script>
    
    <h1 class="mb-4">
        <i class="fa fa-list"></i>
        Kelola Lokasi Pengumpulan Zakat
    </h1>

    <div id="app">
        <collector/>
    </div>
</div>
@endsection