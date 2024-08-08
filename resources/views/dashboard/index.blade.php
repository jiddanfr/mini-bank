@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <!-- Menampilkan pesan sukses atau error jika ada -->
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif

    @if($errors->any())
        <script>
            alert("{{ $errors->first() }}");
        </script>
    @endif

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
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            <button type="button" class="btn btn-secondary btn-block" id="cetakButton" data-url="{{ route('simpan-simpanan-cetak') }}">Submit & Print</button>
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
                            <button type="submit" class="btn btn-danger btn-block">Submit</button>
                            <button type="button" class="btn btn-secondary btn-block" id="penarikanCetakButton" data-url="{{ route('penarikan-cetak') }}">Submit & Print</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Div untuk menampilkan hasil -->
    <div id="result" style="display:none;">
        <h2>Hasil Cetak</h2>
        <iframe id="resultFrame" width="100%" height="600px"></iframe>
    </div>
</div>

<script>
document.getElementById('cetakButton').addEventListener('click', function() {
    let form = document.getElementById('simpanForm');
    let formData = new FormData(form);
    let url = this.getAttribute('data-url');
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.blob())
    .then(blob => {
        let url = URL.createObjectURL(blob);
        let iframe = document.getElementById('resultFrame');
        iframe.src = url;
        document.getElementById('result').style.display = 'block';
    })
    .catch(error => alert('Terjadi kesalahan: ' + error.message));
});

document.getElementById('penarikanCetakButton').addEventListener('click', function() {
    let form = document.getElementById('penarikanForm');
    let formData = new FormData(form);
    let url = this.getAttribute('data-url');
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.blob())
    .then(blob => {
        let url = URL.createObjectURL(blob);
        let iframe = document.getElementById('resultFrame');
        iframe.src = url;
        document.getElementById('result').style.display = 'block';
    })
    .catch(error => alert('Terjadi kesalahan: ' + error.message));
});

</script>
<!-- Menambahkan SweetAlert2 script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
