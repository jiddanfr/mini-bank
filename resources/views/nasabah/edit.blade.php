@extends('layouts.app')

@section('title', 'Edit Data Nasabah')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Data Nasabah</h1>

    <form action="{{ route('nasabah.update', $nasabah->nis) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nis">NIS</label>
            <input type="text" class="form-control" id="nis" name="nis" value="{{ $nasabah->nis }}" required readonly>
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $nasabah->nama }}" required>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $nasabah->kelas }}" required>
        </div>
        <div class="form-group">
            <label for="saldo_total">Saldo Total</label>
            <input type="number" step="0.01" class="form-control" id="saldo_total" name="saldo_total" value="{{ $nasabah->saldo_total }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Nasabah</button>
    </form>
</div>
@endsection
