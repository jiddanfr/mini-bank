<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aplikasi Tabungan Siswa - SD INOVATIF Ma'arif Jogosari Pandaan</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])

    <!-- Link CSS kustom Anda -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- Link CSS khusus untuk pencetakan -->
    <link href="{{ asset('assets/css/print.css') }}" rel="stylesheet" media="print">

    @stack('style')

    <style></style>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/dataTables.fixedColumns.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/fixedColumns.dataTables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('assets/vendor/notyf.min.js') }}"></script>

</head>

<body>
    <!-- Header dengan navbar -->
    @include('layouts.navbar')

    <!-- Main content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Footer -->
    {{-- <footer class="footer bg-dark text-white py-3 fixed-bottom">
        <div class="container">
            <p class="mb-0 text-center">© 2024 appBank - Aplikasi Mini Bank</p>
        </div>
    </footer> --}}

    <script>
        $(document).ready(function() {
            $('.currency').on('keyup', function() {
                var value = $(this).val().replace(/\D/g, '');
                $(this).val(rupiah(value, false));
            });

            var dt = $('#dt').DataTable({
                bInfo: false,
                pageLength: 10,
                lengthChange: false,
                deferRender: true,
                processing: true,
                oLanguage: {
                    "sSearch": "Cari Data",
                    "sEmptyTable": "Tidak ada data yang ditemukan",
                    "sZeroRecords": "Tidak ada data yang ditemukan",
                },
            });
        });

        function rupiah(angka, withRp = true) {
            var number_string = angka.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            return withRp ? "Rp " + rupiah : rupiah;
        }
    </script>

    @stack('script')

    @if ($error = Session::get('error'))
        <script>
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'error',
                    background: '#FA5252',
                    icon: {
                        className: 'bi bi-x-circle',
                        tagName: 'span',
                        color: '#fff'
                    },
                    dismissible: false
                }]
            });
            notyf.open({
                type: 'error',
                message: '<?= $error ?>'
            });
        </script>
    @endif

    @if ($success = Session::get('success'))
        <script>
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'info',
                    background: '#0948B3',
                    icon: {
                        className: 'bi bi-check-circle-fill',
                        tagName: 'span',
                        color: '#fff'
                    },
                    dismissible: false
                }]
            });
            notyf.open({
                type: 'success',
                message: '<?= $success ?>'
            });
        </script>
    @endif

    @if ($message = Session::get('message'))
        <script>
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'info',
                    background: '#0948B3',
                    icon: {
                        className: 'bi bi-info-circle-fill',
                        tagName: 'span',
                        color: '#fff'
                    },
                    dismissible: false
                }]
            });
            notyf.open({
                type: 'info',
                message: '<?= $message ?>'
            });
        </script>
    @endif
</body>

</html>
