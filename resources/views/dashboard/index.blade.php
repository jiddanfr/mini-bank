@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <!-- Simpanan Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Form Simpanan
                </div>
                <div class="card-body">
                    <form id="simpanForm" method="post" action="{{ route('simpan-simpanan') }}">
                        @csrf
                        <div class="form-group">
                            <label for="no_rekening">Nomor Rekening</label>
                            <input type="text" name="TxtNoRekening" id="no_rekening" class="form-control" required placeholder="Masukkan NIS">
                        </div>

                        <div class="form-group">
                            <label for="nominal_simpanan">Nominal Simpanan (Rp)</label>
                            <input type="text" name="TxtNominalSimpanan" id="nominal_simpanan" class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="keterangan_simpanan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan_simpanan" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                            <button type="button" class="btn btn-secondary btn-block" id="simpananCetakButton">Cetak dan simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Penarikan Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    Form Penarikan
                </div>
                <div class="card-body">
                    <form id="penarikanForm" method="post" action="{{ route('simpan-penarikan') }}">
                        @csrf
                        <div class="form-group">
                            <label for="no_rekening_penarikan">Nomor Rekening</label>
                            <input type="text" name="TxtNoRekening" id="no_rekening_penarikan" class="form-control" required placeholder="Masukkan NIS">
                        </div>

                        <div class="form-group">
                            <label for="nominal_penarikan">Nominal Penarikan (Rp)</label>
                            <input type="text" name="TxtNominalPenarikan" id="nominal_penarikan" class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="keterangan_penarikan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan_penarikan" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block">Simpan</button>
                            <button type="button" class="btn btn-secondary btn-block" id="penarikanCetakButton">Cetak dan Tarik</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Div untuk menampilkan hasil -->
    <div id="result" style="display:none;">
        <h2>Hasil Transaksi</h2>
        <div id="result-content">
            <!-- Hasil akan ditampilkan di sini -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
     const baseUrl = "{{ url('') }}"; // Mendapatkan base URL aplikasi

    document.addEventListener('DOMContentLoaded', function() {
        function handleFormPrint(formId, routeName) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);
            const queryString = new URLSearchParams(formData).toString();
            const url = `${baseUrl}/${routeName}?${queryString}`;

            fetch(url, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                const resultContent = document.getElementById('result-content');
                resultContent.innerHTML = `
                    <h2>Hasil Transaksi</h2>
                    <p><strong>Nomor Rekening:</strong> ${data.no_rekening}</p>
                    <p><strong>Nominal:</strong> ${data.nominal_penarikan || data.nominal_simpanan}</p>
                    <p><strong>Keterangan:</strong> ${data.keterangan}</p>
                `;
                document.getElementById('result').style.display = 'block';

                // Trigger dialog cetak
                window.print();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('result-content').innerHTML = `
                    <p>Terjadi kesalahan: ${error.message}</p>
                `;
                document.getElementById('result').style.display = 'block';
            });
        }

        document.getElementById('simpananCetakButton').addEventListener('click', function() {
            handleFormPrint('simpanForm', 'simpan-simpanan-cetak');
        });

        document.getElementById('penarikanCetakButton').addEventListener('click', function() {
            handleFormPrint('penarikanForm', 'penarikan-cetak');
        });
    });
</script>

@endpush
