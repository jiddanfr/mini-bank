@extends('layouts.app')

@section('content')
    <h1>Riwayat Rekapan Bulanan</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Total Simpanan</th>
                <th>Total Penarikan</th>
                <th>Saldo Awal</th>
                <th>Saldo Akhir</th>
                <th>Dibuat Pada</th>
                <th>Diperbarui Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatRekapan as $rekapan)
                <tr>
                    <td>{{ $rekapan->id }}</td>
                    <td>{{ $rekapan->bulan }}</td>
                    <td>{{ $rekapan->tahun }}</td>
                    <td>{{ number_format($rekapan->total_simpanan, 2, ',', '.') }}</td>
                    <td>{{ number_format($rekapan->total_penarikan, 2, ',', '.') }}</td>
                    <td>{{ number_format($rekapan->saldo_awal, 2, ',', '.') }}</td>
                    <td>{{ number_format($rekapan->saldo_akhir, 2, ',', '.') }}</td>
                    <td>{{ $rekapan->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $rekapan->updated_at->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
