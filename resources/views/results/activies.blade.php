<!DOCTYPE html>
<html>
<head>
    <title>Daftar Aktivitas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Daftar Aktivitas</h1>
    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Jenis Aktivitas</th>
                <th>Jumlah (Rp)</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>{{ $activity->nis }}</td>
                    <td>{{ $activity->jenis_aktifitas }}</td>
                    <td>{{ number_format($activity->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $activity->keterangan }}</td>
                    <td>{{ $activity->tanggal->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
