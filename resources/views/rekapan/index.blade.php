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

        <div class="card shadow rounded-3">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $aktivitas)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $aktivitas->nis }}</td>
                                <td>{{ $aktivitas->nama }}</td>
                                <td>{{ $aktivitas->kelas }}</td>
                                <td>
                                    @php
                                        $aktivitasDetails = explode('|', $aktivitas->aktivitas_details);
                                        $lastThreeAktivitas = array_slice($aktivitasDetails, -3);
                                    @endphp
                                    {!! implode('<br>', $lastThreeAktivitas) !!}
                                </td>
                                <td>{{ rupiah($aktivitas->saldo_total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
