@extends('layouts.app')

@section('title', 'Print Aktifitas')

@section('content')
<div class="container">
    <h1 class="mb-4">Print Aktifitas</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Aktifitas</h5>
            <p class="card-text"><strong>NIS:</strong> {{ $aktifitas->nis }}</p>
            <p class="card-text"><strong>Nama Nasabah:</strong> {{ $aktifitas->nasabah->nama }}</p>
            <p class="card-text"><strong>Jumlah:</strong> Rp {{ number_format($aktifitas->jumlah, 0, ',', '.') }}</p>
            <p class="card-text"><strong>Tanggal:</strong> {{ $aktifitas->tanggal }}</p>
            <p class="card-text"><strong>Jenis Aktifitas:</strong> {{ $aktifitas->jenis_aktifitas }}</p>
            <p class="card-text"><strong>Keterangan:</strong> {{ $aktifitas->keterangan }}</p>
        </div>
    </div>

    <div class="mt-4">
        <button class="btn btn-primary" onclick="window.print();">Print Passbook</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
