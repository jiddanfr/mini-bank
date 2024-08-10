@extends('layouts.app')

@section('title', 'Data Nasabah')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Nasabah</h1>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    <!-- Form Pencarian -->
    <form action="{{ route('nasabah.search') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari NIS atau Nama" value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-header bg-primary text-white">
            Daftar Nasabah
            <!-- Tombol Import Data -->
            <form action="{{ route('nasabah.import') }}" method="POST" enctype="multipart/form-data" style="position: absolute; top: 10px; right: 10px;">
                @csrf
                <div class="form-group mb-0">
                    <input type="file" name="file" id="file" class="form-control form-control-sm d-inline" style="display: inline-block; width: auto;">
                    <button type="submit" class="btn btn-success btn-sm">Import</button>
                </div>
            </form>
            <!-- Tombol Tambah Nasabah -->
            <a href="{{ route('nasabah.create') }}" class="btn btn-primary btn-lg rounded-circle"
               style="position: fixed; bottom: 80px; right: 20px; background-color: #007bff; color: white;">
                +
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Saldo Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nasabahs as $index => $nasabah)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $nasabah->nis }}</td>
                            <td>{{ $nasabah->nama }}</td>
                            <td>{{ $nasabah->kelas }}</td>
                            <td>{{ number_format($nasabah->saldo_total, 2) }}</td>
                            <td>
                                <a href="{{ route('nasabah.edit', $nasabah->nis) }}" class="btn btn-warning btn-sm">Edit</a>
                                
                                <!-- Form Hapus dengan konfirmasi menggunakan SweetAlert -->
                                <form action="{{ route('nasabah.destroy', $nasabah->nis) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data nasabah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginasi -->
            <div class="mt-4">
                {{ $nasabahs->links() }}
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin ingin menghapus nasabah ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
