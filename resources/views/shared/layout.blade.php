<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('head')
</head>
<body>
    @include('shared.navbar')

    <div class="container">
        @auth
        <div class="alert alert-primary">
            Anda masuk sebagai <strong> {{ auth()->user()->name }} </strong>
            ({{ auth()->user()->description }})
        </div>
        @endauth
    </div>

    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</body>
</html>