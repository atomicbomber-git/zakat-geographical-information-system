@extends('shared.layout')
@section('title', 'Sunting Data Unit Pengumpulan Zakat')
@section('content')
<div class="container my-5">
    <script>
        window.submit_url='{{ route('collector.update', $collector) }}'

        icon_url = '{{ asset('png/location.png') }}'

        window.collector = {
            latitude: {{ $collector->latitude }},
            longitude: {{ $collector->longitude }},
            name: '{{ $collector->name }}',
            address: `{{ $collector->address }}`,
            npwz: '{{ $collector->npwz }}',
            user: {
                name: '{{ $collector->user->name }}',
                username: '{{ $collector->user->username }}'
            }
        }

        window.collectors = []

        @foreach ($collectors as $collector)
        window.collectors.push({
            id: {{ $collector->id }},
            name: '{{ $collector->name }}',
            address: `{{ $collector->address }}`,
            latitude: {{ $collector->latitude }},
            longitude: {{ $collector->longitude }},
            imageUrl: '{{ route('collector.thumbnail', $collector) . "?" . rand() }}'
        })
        @endforeach

    </script>

    <h1 class="mb-5">
        <i class="fa fa-pencil"></i>
        Sunting Data Unit Pengumpulan Zakat
    </h1>

    <div id="app">
        <collector-edit/>
    </div>
</div>
@endsection