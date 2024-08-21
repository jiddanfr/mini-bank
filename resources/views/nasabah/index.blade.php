@extends('layouts.app')

@section('title', 'Data Nasabah')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Data Nasabah</h2>
            <div class="d-flex gap-2">
                <!-- Form Import -->
                <form action="{{ route('nasabah.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <div class="d-flex">
                        <input type="file" name="file" id="file" class="form-control form-control-sm" style="width: auto; height: 34px;">
                        <button type="submit" class="btn btn-success btn-sm ml-2">Import</button>
                    </div>
                </form>
                <!-- Tambah Nasabah -->
                <a href="{{ route('nasabah.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus icon-bg"></i> Tambah Nasabah
                </a>
            </div>
        </div>

        <!-- Filter dan Tabel Data Nasabah -->
        <div class="card shadow rounded-3">
            <div class="card-body">
                <!-- Filter Kelas -->
                <form action="{{ route('nasabah.index') }}" method="GET" id="formCari" class="mb-3">
                    <div class="d-flex flex-column gap-3">
                        <div class="form-group">
                            
                            <select name="kelas" id="kelas" class="form-control form-control-sm" onchange="cariKelas(this.value)">
                                <option value="">Semua Kelas</option>
                                @foreach ($kelasList as $kelasItem)
                                    <option value="{{ $kelasItem }}" {{ $kelas == $kelasItem ? 'selected' : '' }}>
                                        {{ $kelasItem }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                <!-- Tabel Data Nasabah -->
                <table class="table table-striped" id="dtnasabah">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Saldo Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nasabahs as $index => $nasabah)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $nasabah->nis }}</td>
                                <td>{{ $nasabah->nama }}</td>
                                <td>{{ $nasabah->kelas }}</td>
                                <td>{{ rupiah($nasabah->saldo_total) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('nasabah.edit', $nasabah->nis) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('nasabah.destroy', $nasabah->nis) }}" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus nasabah ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .icon-bg {
            background-color: #f0f0f0;
            border-radius: 50%;
            padding: 5px;
        }
        #kelas {
            width: 150px; /* Sesuaikan lebar dropdown */
            height: 30px; /* Sesuaikan tinggi dropdown */
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#dtnasabah').DataTable({
                bInfo: false,
                pageLength: 10,
                lengthChange: false,
                deferRender: true,
                processing: true,
                language: {
                    search: "Cari Nasabah",
                    emptyTable: "Tidak ada data nasabah.",
                    zeroRecords: "Tidak ada data nasabah.",
                },
            });

            // Filter berdasarkan kelas
            $('#kelas').on('change', function() {
                $('#formCari').submit();
            });
        });

        
    </script>
@endpush
