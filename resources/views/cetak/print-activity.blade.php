<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Aktivitas</title>
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                padding: 0;
                background: #fff;
                color: #000;
            }
            .container {
                width: 100%;
                margin: 0;
                padding: 0;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            h2 {
                text-align: center;
                margin-bottom: 20px;
            }
            .activity-details {
                margin-top: 20px;
            }
            .activity-details p {
                font-size: 14px;
                line-height: 1.5;
            }
            .no-print {
                display: none;
            }
        }
        @media screen {
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                padding: 0;
                background: #f9f9f9;
            }
            .container {
                width: 80%;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background: #fff;
            }
            h2 {
                text-align: center;
            }
            .activity-details {
                margin-top: 20px;
            }
            .activity-details p {
                font-size: 16px;
                line-height: 1.6;
            }
            .print-btn {
                text-align: center;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cetak Aktivitas</h2>
        <div class="activity-details">
            <p><strong>ID Aktivitas:</strong> {{ $activity->id }}</p>
            <p><strong>ID Nasabah:</strong> {{ $activity->nasabah_id }}</p>
            <p><strong>Keterangan:</strong> {{ $activity->keterangan }}</p>
            <p><strong>Jenis Aktivitas:</strong> {{ $activity->jenis_aktifitas }}</p>
            <p><strong>Tanggal:</strong> {{ $activity->created_at->format('d M Y H:i:s') }}</p>
        </div>
        <div class="print-btn">
            <button onclick="window.print()">Cetak</button>
        </div>
    </div>
</body>
</html>
