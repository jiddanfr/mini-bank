<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'appBank | Aplikasi Mini Bank')</title>
    <!-- Link CSS Bootstrap dari CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link CSS kustom Anda -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Link CSS khusus untuk pencetakan -->
    <link href="{{ asset('css/print.css') }}" rel="stylesheet" media="print">
</head>
<body>
    <!-- Header dengan navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.jpg') }}" width="30" height="30" class="d-inline-block align-top" alt="Logo">
            appBank
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Data Nasabah dan Data Teller
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('nasabah.index') }}">Data Nasabah</a>
                        <a class="dropdown-item" href="#">Data Teller</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('activities.index') }}">Aktifitas</a>
                </li>
                <li class="nav-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pengaturan.index') }}">Pengaturan Administrasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Rekapan</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-white py-3 fixed-bottom">
        <div class="container">
            <p class="mb-0 text-center">© 2024 appBank - Aplikasi Mini Bank</p>
        </div>
    </footer>

    <!-- Script JavaScript Bootstrap dari CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
