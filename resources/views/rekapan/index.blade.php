@extends('layouts.app')

@section('title', 'Rekapan')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Rekapan Aktivitas</h2>
            <!-- Form untuk Simpan dan Unduh Rekapan Tahunan -->
            <form action="{{ route('rekapan.storeYearly') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Simpan dan Unduh Rekapan Tahunan</button>
            </form>
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
                            <th>Saldo Awal</th>
                            <th>Saldo Akhir</th>
                            <th>Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
        @foreach ($data as $key => $nasabah)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $nasabah->nis }}</td>
                <td>{{ $nasabah->nama }}</td>
                <td>{{ $nasabah->kelas }}</td>
                <td>{{ rupiah($nasabah->saldo_awal) }}</td>
                <td>{{ rupiah($nasabah->saldo_akhir) }}</td>
                <td>
                    @if (!empty($nasabah->aktivitas_details))
                        {!! str_replace('|', '<br>', $nasabah->aktivitas_details) !!}
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
