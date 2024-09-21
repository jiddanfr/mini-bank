@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Nasabah</h2>
    <form action="{{ route('nasabah.update', $nasabah->nis) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="nis" class="form-label">NIS</label>
            <input type="text" class="form-control" id="nis" name="nis" value="{{ $nasabah->nis }}" readonly>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $nasabah->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $nasabah->kelas }}" required>
        </div>

        <div class="mb-3">
            <label for="saldo_total" class="form-label">Saldo Total</label>
            <input type="number" class="form-control" id="saldo_total" name="saldo_total" value="{{ $nasabah->saldo_total }}" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('nasabah.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
