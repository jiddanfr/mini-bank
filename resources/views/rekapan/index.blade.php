@extends('layouts.app')

@section('title', 'Rekapan')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4">Rekapan Aktivitas</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('rekapan.export') }}" class="btn btn-primary btn-sm" style="padding-right: 15px;">
                    <i class="bi bi-plus icon-bg"></i> Download Rekapan
                </a>
            </div>
        </div>

        <div class="card shadow rouded-3">
            <div class="card-body">
                <table class="table table-striped" id="dt">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Aktivitas</th>
                            <th>Saldo Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $aktivitas)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $aktivitas->nis }}</td>
                                <td>{{ $aktivitas->nama }}</td>
                                <td>{{ $aktivitas->kelas }}</td>
                                <td>{{ $aktivitas->aktivitas_details }}</td>
                                <td>{{ rupiah($aktivitas->saldo_total) }}</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye icon-bg"></i> Lihat Riwayat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
