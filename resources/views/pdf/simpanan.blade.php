<!DOCTYPE html>
<html>
<head>
    <title>Detail Simpanan</title>
</head>
<body>
    <h1>Detail Simpanan</h1>
    <p><strong>Nomor Rekening:</strong> {{ $nasabah->nis }}</p>
    <p><strong>Nama:</strong> {{ $nasabah->nama }}</p>
    <p><strong>Jumlah Simpanan:</strong> Rp{{ number_format($totalSimpanan, 0, ',', '.') }}</p>
    <p><strong>Saldo Akhir:</strong> Rp{{ number_format($saldoAkhir, 0, ',', '.') }}</p>
    <p><strong>Keterangan:</strong> {{ $keterangan }}</p>
    <p><strong>Tanggal:</strong> {{ $tanggal }}</p>
</body>
</html>
