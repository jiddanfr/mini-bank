@extends('layouts.app')

@section('title', 'Data Nasabah')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Nasabah</h1>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Form Pencarian dan Dropdown Kelas -->
    <form action="{{ route('nasabah.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <select name="kelas" class="form-control"  onchange="this.form.submit()">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $kelasItem)
                    <option value="{{ $kelasItem }}" {{ $kelas == $kelasItem ? 'selected' : '' }}>
                        {{ $kelasItem }}
                    </option>
                @endforeach
            </select>
            <input type="text" name="search" class="form-control" style="width: 70%;"placeholder="Cari NIS atau Nama" value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Daftar Nasabah</span>
            <!-- Tombol Import Data -->
            <form action="{{ route('nasabah.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                @csrf
                <div class="form-group mb-0 d-flex">
                    <input type="file" name="file" id="file" class="form-control form-control-sm d-inline" style="width: auto; height: 34px;">
                    <button type="submit" class="btn btn-success btn-sm ml-2">Import</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <!-- Tombol Tambah Nasabah -->
            <a href="{{ route('nasabah.create') }}" class="btn btn-primary btn-lg rounded-circle"
               style="position: fixed; bottom: 80px; right: 20px; background-color: #007bff; color: white;">
                +
            </a>

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
                                
                                <!-- Form Hapus dengan konfirmasi JavaScript -->
                                <form action="{{ route('nasabah.destroy', $nasabah->nis) }}" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus nasabah ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
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
</div>
@endsection
