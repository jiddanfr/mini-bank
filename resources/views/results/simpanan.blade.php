<!DOCTYPE html>
<html>
<head>
    <title>Hasil Simpanan</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Hasil Simpanan</h1>
        <ul>
            <li><strong>Nomor Rekening:</strong> {{ $data['no_rekening'] }}</li>
            <li><strong>Nominal Simpanan:</strong> {{ number_format($data['nominal_simpanan'], 0, ',', '.') }}</li>
            <li><strong>Keterangan:</strong> {{ $data['keterangan'] }}</li>
        </ul>
        <button onclick="window.print()">Cetak</button>
    </div>
</body>
</html>
