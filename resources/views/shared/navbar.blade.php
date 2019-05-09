@php
    use Illuminate\Support\Facades\Auth;
@endphp

<nav class="navbar navbar-dark bg-dark navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container">
        <a class="navbar-brand" href="/"> Sistem Informasi Geografis Zakat </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav mr-auto">
                @can('act-as-administrator')

                    <li class="nav-item {{ Route::is("collector.*") ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('collector.index') }}">
                            <i class="fa fa-building"></i>
                            Unit Pengumpulan Zakat
                        </a>
                    </li>

                    <li class='nav-item {{ Route::is('admin-report.*') ? 'active' : '' }}'>
                        <a class='nav-link' href='{{ route('admin-report.index') }}'>
                            <i class='fa fa-usd'></i>
                            Laporan
                        </a>
                    </li>

                    <li class='nav-item {{ Route::is('donation.*') ? 'active' : '' }}'>
                        <a class='nav-link' href='{{ route('donation.index') }}'>
                            <i class='fa fa-arrow-up'></i>
                            Pemberian Zakat
                        </a>
                    </li>

                @endcan

                @can('act-as-collector')
                    
                    <li class='nav-item dropdown {{ Route::is('collector.*') ? 'active' : '' }}'>
                        <a
                            class='nav-link dropdown-toggle' href='#' id='collector' role='button'
                            data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            Zakat
                        </a>
                        <div class='dropdown-menu' aria-labelledby='collector'>
                            <a class='dropdown-item' href='{{ route('collector.donation.index') }}'>
                                <i class='fa fa-arrow-up'></i>
                                Pemberian Zakat
                            </a>
    
                            <a class='dropdown-item' href='{{ route('collector.receivement.index') }}'>
                                <i class='fa fa-arrow-down'></i>
                                Penerimaan Zakat
                            </a>

                            <a class='dropdown-item' href='{{ route('report.index') }}'>
                                <i class='fa fa-usd'></i>
                                Laporan
                            </a>
                        </div>
                    </li>

                    <li class='nav-item {{ Route::is('collector.mustahiq.*') ? 'active' : '' }}'>
                        <a class='nav-link' href='{{ route('collector.mustahiq.index') }}'>
                            <i class='fa fa-user'></i>
                            Mustahiq
                        </a>
                    </li>

                    <li class='nav-item {{ Route::is('collector.muzakki.*') ? 'active' : '' }}'>
                        <a class='nav-link' href='{{ route('collector.muzakki.index') }}'>
                            <i class='fa fa-user'></i>
                            Muzakki
                        </a>
                    </li>
                @endcan

                <li class="nav-item {{ Route::is("guest.*") ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('guest.map') }}">
                        <i class="fa fa-map"></i>
                        Peta
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa fa-user"></i>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-info">
                        Log In
                        <i class="fa fa-sign-in"></i>
                    </a>
                @endguest
            </ul>
        </div>
    </div>
</nav>