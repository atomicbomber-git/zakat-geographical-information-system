<nav class="navbar navbar-dark bg-dark navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container">
        <a class="navbar-brand" href="#"> Sistem Informasi Geografis Zakat </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Route::is("collector.*") ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('collector.index') }}">
                        <i class="fa fa-list"></i>
                        Pengumpul Zakat
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>