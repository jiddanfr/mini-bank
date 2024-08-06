@extends('layouts.app')

@section('title', 'Tambah Nasabah Baru')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Nasabah Baru</h1>

    <form action="{{ route('nasabah.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nis">NIS</label>
            <input type="text" class="form-control" id="nis" name="nis" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input type="text" class="form-control" id="kelas" name="kelas" required>
        </div>
        <div class="form-group">
            <label for="saldo_total">Saldo Total</label>
            <input type="number" step="0.01" class="form-control" id="saldo_total" name="saldo_total" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah Nasabah</button>
    </form>
</div>
@endsection
