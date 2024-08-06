@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pengaturan Administrasi</h1>
        
        @if($pengaturan)
            <form action="{{ route('pengaturan.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="biaya_penarikan">Biaya Penarikan</label>
                    <input type="number" name="biaya_penarikan" id="biaya_penarikan" class="form-control" value="{{ old('biaya_penarikan', $pengaturan->biaya_penarikan) }}" step="0.01">
                    @error('biaya_penarikan')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="biaya_penyimpanan">Biaya Penyimpanan</label>
                    <input type="number" name="biaya_penyimpanan" id="biaya_penyimpanan" class="form-control" value="{{ old('biaya_penyimpanan', $pengaturan->biaya_penyimpanan) }}" step="0.01">
                    @error('biaya_penyimpanan')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="administrasi_bulanan">Administrasi Bulanan</label>
                    <input type="number" name="administrasi_bulanan" id="administrasi_bulanan" class="form-control" value="{{ old('administrasi_bulanan', $pengaturan->administrasi_bulanan) }}" step="0.01">
                    @error('administrasi_bulanan')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="minimal_saldo_tarik">Minimal Saldo yang Bisa Ditarik</label>
                    <input type="number" name="minimal_saldo_tarik" id="minimal_saldo_tarik" class="form-control" value="{{ old('minimal_saldo_tarik', $pengaturan->minimal_saldo_tarik) }}" step="0.01">
                    @error('minimal_saldo_tarik')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        @else
            <p>Pengaturan Administrasi tidak ditemukan.</p>
        @endif
    </div>
@endsection
