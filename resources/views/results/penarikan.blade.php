<!DOCTYPE html>
<html>
<body>
    <p>{{ $aktifitas->tanggal }}</p>
    <p>-<p>
    <p>{{ number_format($aktifitas->jumlah, 0, ',', '.') }}</p>
    
    <p>{{ $aktifitas->keterangan }}</p>
</body>
</html>
