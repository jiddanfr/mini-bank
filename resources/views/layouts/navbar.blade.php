<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <!-- <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.jpg') }}" width="30" height="30" class="d-inline-block align-top" alt="Logo">
            appBank
        </a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item {{ request()->routeIs('nasabah') ? 'active' : '' }}">
                    <a class="nav-link active" aria-current="page" href="{{ route('nasabah.index') }}">Data Nasabah</a>
                </li>
                {{-- <li class="nav-item dropdown {{ request()->routeIs('nasabah.*') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Data Master
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('nasabah.index') }}">Data Nasabah</a></li>
                        <li><a class="dropdown-item" href="#">Data Teller</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li> --}}
                <li class="nav-item {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('activities.index') }}">Aktifitas</a>
                </li>
                <li class="nav-item {{ request()->routeIs('rekapan.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('rekapan.index') }}">Rekapan</a>
                </li>
                <li class="nav-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pengaturan.index') }}">Pengaturan</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
