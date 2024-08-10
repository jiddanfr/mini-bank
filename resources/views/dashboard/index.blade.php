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
    // Format nominal sebagai mata uang
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
}

function printSimpanan() {
    // Ambil nilai dari input dan textarea
    const nominalSimpanan = document.getElementById('nominal_simpanan').value;
    const keteranganSimpanan = document.getElementById('keterangan_simpanan').value;

    // Cek apakah input kosong
    if (nominalSimpanan === '' || keteranganSimpanan === '') {
        Swal.fire({
            title: 'Error!',
            text: 'Nominal dan Keterangan tidak boleh kosong!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return; // Menghentikan eksekusi jika input kosong
    }

    // Validasi nominal
    const nominalValue = parseInt(nominalSimpanan.replace(/\D/g, ''));
    if (isNaN(nominalValue) || nominalValue <= 0) {
        Swal.fire({
            title: 'Error!',
            text: 'Nominal tidak valid!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return; // Menghentikan eksekusi jika nominal tidak valid
    }

    // Ambil tanggal sekarang
    const tanggalSekarang = new Date().toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric'
    });

    // Format nominal
    const formattedNominal = formatCurrency(nominalSimpanan);

    // Buat konten untuk dicetak
    const printContent = `
        <div style="font-size: 14px;">
            <p>${tanggalSekarang} - ${formattedNominal} - ${keteranganSimpanan}</p>
        </div>
    `;

    // Membuat jendela baru untuk mencetak
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Simpanan</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
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

    // Setelah mencetak, submit form
    document.getElementById('simpanForm').submit();

    // Notifikasi sukses
    Swal.fire({
        title: 'Success!',
        text: 'Simpan dan cetak berhasil!',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function printPenarikan() {
    // Ambil nilai dari input dan textarea
    const nominalPenarikan = document.getElementById('nominal_penarikan').value;
    const keteranganPenarikan = document.getElementById('keterangan_penarikan').value;

    // Cek apakah input kosong
    if (nominalPenarikan === '' || keteranganPenarikan === '') {
        Swal.fire({
            title: 'Error!',
            text: 'Nominal dan Keterangan tidak boleh kosong!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return; // Menghentikan eksekusi jika input kosong
    }

    // Validasi nominal
    const nominalValue = parseInt(nominalPenarikan.replace(/\D/g, ''));
    if (isNaN(nominalValue) || nominalValue <= 0) {
        Swal.fire({
            title: 'Error!',
            text: 'Nominal tidak valid!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return; // Menghentikan eksekusi jika nominal tidak valid
    }

    // Ambil tanggal sekarang
    const tanggalSekarang = new Date().toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric'
    });

    // Format nominal
    const formattedNominal = formatCurrency(nominalPenarikan);

    // Buat konten untuk dicetak
    const printContent = `
        <div style="font-size: 14px;">
            <p>${tanggalSekarang} - ${formattedNominal} - ${keteranganPenarikan}</p>
        </div>
    `;

    // Membuat jendela baru untuk mencetak
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Penarikan</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
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

    // Setelah mencetak, submit form
    document.getElementById('penarikanForm').submit();

    // Notifikasi sukses
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
