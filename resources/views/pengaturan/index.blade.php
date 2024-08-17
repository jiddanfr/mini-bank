@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pengaturan Administrasi</h1>

        @if ($pengaturan)
            <div class="card shadow rounded-3">
                <div class="card-body">
                    <form action="{{ route('pengaturan.update') }}" method="POST" id="formPengaturan">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="biaya_penarikan">
                        <input type="hidden" name="biaya_penyimpanan">
                        <input type="hidden" name="administrasi_bulanan">
                        <input type="hidden" name="minimal_saldo_tarik">
                        <input type="hidden" name="minimal_jumlah_saldo">
                        <input type="hidden" name="minimal_simpanan">

                        <div class="mb-3">
                            <label for="biaya_penarikan">Biaya Penarikan</label>
                            <input type="text" id="biaya_penarikan"
                                class="form-control {{ $errors->has('biaya_penarikan') ? 'is-invalid' : '' }} currency"
                                value="">

                            @error('biaya_penarikan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="biaya_penyimpanan">Biaya Penyimpanan</label>
                            <input type="text" id="biaya_penyimpanan"
                                class="form-control {{ $errors->has('biaya_penyimpanan') ? 'is-invalid' : '' }} currency"
                                value="">

                            @error('biaya_penyimpanan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="administrasi_bulanan">Administrasi Bulanan</label>
                            <input type="text" id="administrasi_bulanan"
                                class="form-control {{ $errors->has('administrasi_bulanan') ? 'is-invalid' : '' }} currency"
                                value="">

                            @error('administrasi_bulanan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="minimal_saldo_tarik">Minimal Saldo yang Bisa Ditarik</label>
                            <input type="text" id="minimal_saldo_tarik"
                                class="form-control {{ $errors->has('minimal_saldo_tarik') ? 'is-invalid' : '' }} currency"
                                value="">

                            @error('minimal_saldo_tarik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="minimal_jumlah_saldo">Minimal Jumlah Saldo</label>
                            <input type="text" id="minimal_jumlah_saldo"
                                class="form-control {{ $errors->has('minimal_jumlah_saldo') ? 'is-invalid' : '' }} currency"
                                value="">

                            @error('minimal_jumlah_saldo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="minimal_simpanan">Minimal Simpanan</label>
                            <input type="text" name="minimal_simpanan" id="minimal_simpanan"
                                class="form-control {{ $errors->has('minimal_simpanan') ? 'is-invalid' : '' }} currency"
                                value="">

                            @error('minimal_simpanan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="button" id="btnPengaturan" class="btn btn-primary btn-sm float-end w-25">Simpan
                                Pengaturan</button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <p>Pengaturan Administrasi tidak ditemukan.</p>
        @endif
    </div>
@endsection


@push('script')
    <script>
        var biaya_penarikan = '{{ old('biaya_penarikan', $pengaturan->biaya_penarikan) }}';
        var biaya_penyimpanan = '{{ old('biaya_penyimpanan', $pengaturan->biaya_penyimpanan) }}';
        var administrasi_bulanan = '{{ old('administrasi_bulanan', $pengaturan->administrasi_bulanan) }}';
        var minimal_saldo_tarik = '{{ old('minimal_saldo_tarik', $pengaturan->minimal_saldo_tarik) }}';
        var minimal_jumlah_saldo = '{{ old('minimal_jumlah_saldo', $pengaturan->minimal_jumlah_saldo) }}';
        var minimal_simpanan = '{{ old('minimal_simpanan', $pengaturan->minimal_simpanan) }}';

        $(document).ready(function() {
            $('#biaya_penarikan').val(rupiah(biaya_penarikan, false));
            $('#biaya_penyimpanan').val(rupiah(biaya_penyimpanan, false));
            $('#administrasi_bulanan').val(rupiah(administrasi_bulanan, false));
            $('#minimal_saldo_tarik').val(rupiah(minimal_saldo_tarik, false));
            $('#minimal_jumlah_saldo').val(rupiah(minimal_jumlah_saldo, false));
            $('#minimal_simpanan').val(rupiah(minimal_simpanan, false));

            $('#btnPengaturan').on('click', function() {
                $('input[name=biaya_penarikan]').val(replaceDot($('#biaya_penarikan').val()));
                $('input[name=biaya_penyimpanan]').val(replaceDot($('#biaya_penyimpanan').val()));
                $('input[name=administrasi_bulanan]').val(replaceDot($('#administrasi_bulanan').val()));
                $('input[name=minimal_saldo_tarik]').val(replaceDot($('#minimal_saldo_tarik').val()));
                $('input[name=minimal_jumlah_saldo]').val(replaceDot($('#minimal_jumlah_saldo').val()));
                $('input[name=minimal_simpanan]').val(replaceDot($('#minimal_simpanan').val()));

                $('#formPengaturan').submit();
            });

            function replaceDot(value) {
                return value.replace(/\./g, '');
            }
        });
    </script>
@endpush
