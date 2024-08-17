@extends('layouts.app')

@section('title', 'Tambah Nasabah Baru')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4">{{ !isset($post) ? 'Tambah' : 'Edit' }} Nasabah</h2>
            <a href="{{ route('nasabah.index') }}" class="btn btn-primary btn-sm" style="padding-right: 15px;">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow rounded-3">
            <div class="card-body">
                <form action="{{ !isset($post) ? route('nasabah.store') : route('nasabah.update', $post->nis) }}" method="POST">
                    @csrf
                    @if (isset($post))
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control {{ $errors->has('nis') ? 'is-invalid' : '' }}"
                            id="nis" name="nis" {{ !isset($post) ? '' : 'disabled' }} value="{{ isset($post) ? $post->nis : '' }}">

                        @error('nis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                            id="nama" name="nama" value="{{ isset($post) ? $post->nama : '' }}">

                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control {{ $errors->has('kelas') ? 'is-invalid' : '' }}"
                            id="kelas" name="kelas" value="{{ isset($post) ? $post->kelas : '' }}">

                        @error('kelas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="saldo_total" class="form-label">Saldo Total</label>
                        <input type="number" step="0.01"
                            class="form-control {{ $errors->has('saldo_total') ? 'is-invalid' : '' }}" id="saldo_total"
                            name="saldo_total" value="{{ isset($post) ? $post->saldo_total : '' }}">

                        @error('saldo_total')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-{{ !isset($post) ? 'primary' : 'warning' }} btn-sm float-end w-25">{{ !isset($post) ? 'Tambah' : 'Edit' }} Nasabah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
