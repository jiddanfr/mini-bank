@extends('layouts.app')

@section('title', 'Data Nasabah')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Nasabah</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            Daftar Nasabah
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Saldo Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nasabahs as $index => $nasabah)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $nasabah->nis }}</td>
                            <td>{{ $nasabah->nama }}</td>
                            <td>{{ $nasabah->kelas }}</td>
                            <td>{{ number_format($nasabah->saldo_total, 2) }}</td>
                            <td>
                                <a href="{{ route('nasabah.edit', $nasabah->nis) }}" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data nasabah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol Tambah Nasabah -->
    <a href="{{ route('nasabah.create') }}" class="btn btn-primary btn-lg rounded-circle"
       style="position: fixed; bottom: 80px; right: 20px; background-color: #007bff; color: white;">
        +
    </a>
</div>
@endsection
