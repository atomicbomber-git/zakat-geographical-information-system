<nav class="navbar navbar-dark bg-dark navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container">
        <a class="navbar-brand" href="#"> Sistem Informasi Geografis Zakat </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav mr-auto">
                @can('act-as-administrator')

                    <li class="nav-item dropdown {{ Route::is("collector.*") ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="collectorMenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-list"></i>
                            Pengumpul Zakat
                        </a>
                        <div class="dropdown-menu" aria-labelledby="collectorMenuDropdown">
                            <a class="dropdown-item" href="{{ route('collector.index') }}"> Kelola Pengumpul </a>
                            <a class="dropdown-item" href="{{ route('collector.user.index') }}"> Kelola Akun Pengumpul </a>
                        </div>
                    </li>

                    <li class="nav-item {{ Route::is("report.*") ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('report.index') }}">
                            <i class="fa fa-list"></i>
                            Laporan Zakat
                        </a>
                    </li>
                @endcan

                @can('act-as-collector')
                    <li class="nav-item {{ Route::is("collector.report.*") ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('collector.report.index', auth()->user()->collector) }}">
                            <i class="fa fa-list"></i>
                            Laporan Zakat
                        </a>
                    </li>
                @endcan
            </ul>

            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
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
            </ul>
        </div>
    </div>
</nav>