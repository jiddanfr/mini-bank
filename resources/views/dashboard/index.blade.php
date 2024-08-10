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
                            <input type="text" name="TxtNominalSimpanan" id="nominal_simpanan" class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="keterangan_simpanan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan_simpanan" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            <!-- Tombol Submit & Print dihilangkan -->
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
                            <!-- Tombol Submit & Print dihilangkan -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Menambahkan SweetAlert2 script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
