@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <!-- Menampilkan pesan sukses atau error jika ada -->
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            Swal.fire({
                title: 'Error!',
                text: "{{ $errors->first() }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
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
                            <input type="text" name="TxtNominalSimpanan" id="nominal_simpanan" class="form-control" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label for="keterangan_simpanan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan_simpanan" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-block" onclick="printSimpanan()">Print & Submit</button>
                            <button type="submit" class="btn btn-secondary btn-block no-print">Submit</button>
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
                            <input type="text" name="TxtNominalPenarikan" id="nominal_penarikan" class="form-control" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label for="keterangan_penarikan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan_penarikan" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-danger btn-block" onclick="printPenarikan()">Print & Submit</button>
                            <button type="submit" class="btn btn-secondary btn-block no-print">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function formatCurrency(value) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
}

// Fungsi untuk menyimpan dan mengelola indeks baris aktifitas
function getActivityIndex(nis) {
    const key = `activityIndex_${nis}`;
    let index = parseInt(localStorage.getItem(key)) || 0;
    index = (index % 20) + 1; // Sirkulasi antara 1 sampai 20
    localStorage.setItem(key, index);
    return index;
}

function printSimpanan(nis) {
    const nominalSimpanan = document.getElementById('nominal_simpanan').value;
    const keteranganSimpanan = document.getElementById('keterangan_simpanan').value;

    if (nominalSimpanan === '' || keteranganSimpanan === '') {
        Swal.fire({
            title: 'Error!',
            text: 'Nominal dan Keterangan tidak boleh kosong!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    const nominalValue = parseInt(nominalSimpanan.replace(/\D/g, ''));
    if (isNaN(nominalValue) || nominalValue <= 0) {
        Swal.fire({
            title: 'Error!',
            text: 'Nominal tidak valid!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    const tanggalSekarang = new Date().toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric'
    });

    const formattedNominal = formatCurrency(nominalSimpanan);

    // Dapatkan indeks baris berdasarkan NIS
    const activityIndex = getActivityIndex(nis);

    const printContent = `
        <div style="font-size: 14px; position: absolute; top: ${activityIndex * 20}px;">
            <p>${tanggalSekarang}&nbsp;&nbsp;${formattedNominal}&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;${keteranganSimpanan}</p>
        </div>
    `;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Simpanan</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; position: relative; height: 400px; }
            </style>
        </head>
        <body>
            ${printContent}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();

    document.getElementById('simpanForm').submit();

    Swal.fire({
        title: 'Success!',
        text: 'Simpan dan cetak berhasil!',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function printPenarikan(nis) {
    const nominalPenarikan = document.getElementById('nominal_penarikan').value;
    const keteranganPenarikan = document.getElementById('keterangan_penarikan').value;

    if (nominalPenarikan === '' || keteranganPenarikan === '') {
        Swal.fire({
            title: 'Error!',
            text: 'Nominal dan Keterangan tidak boleh kosong!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    const nominalValue = parseInt(nominalPenarikan.replace(/\D/g, ''));
    if (isNaN(nominalValue) || nominalValue <= 0) {
        Swal.fire({
            title: 'Error!',
            text: 'Nominal tidak valid!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    const tanggalSekarang = new Date().toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric'
    });

    const formattedNominal = formatCurrency(nominalPenarikan);

    // Dapatkan indeks baris berdasarkan NIS
    const activityIndex = getActivityIndex(nis);

    const printContent = `
        <div style="font-size: 14px; position: absolute; top: ${activityIndex * 20}px;">
            <p>${tanggalSekarang}&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;${formattedNominal}&nbsp;&nbsp;${keteranganPenarikan}</p>
        </div>
    `;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Penarikan</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; position: relative; height: 400px; }
            </style>
        </head>
        <body>
            ${printContent}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();

    document.getElementById('penarikanForm').submit();

    Swal.fire({
        title: 'Success!',
        text: 'Penarikan berhasil!',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}
</script>


<!-- Menambahkan SweetAlert2 script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
