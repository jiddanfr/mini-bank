@extends('layouts.app')

@section('title', 'Data Nasabah')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4">Data Nasabah</h2>
            <div class="d-flex gap-2">
                <form action="{{ route('nasabah.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <div class="form-group
                        d-flex">
                        <input type="file" name="file" id="file" class="form-control form-control-sm d-inline"
                            style="width: auto; height: 34px;">
                        <button type="submit" class="btn btn-success btn-sm ml-2">Import</button>
                    </div>
                </form>
                <a href="{{ route('nasabah.create') }}" class="btn btn-primary btn-sm" style="padding-right: 15px;">
                    <i class="bi bi-plus icon-bg"></i> Tambah Nasabah
                </a>
            </div>
        </div>

        <div class="card rounded-3 shadow-sm mb-4">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-4">
                        <select name="kelas" id="kelas" class="form-control w-100" onchange="cariKelas(this.value)">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelasList as $kelasItem)
                                <option value="{{ $kelasItem }}" {{ $kelas == $kelasItem ? 'selected' : '' }}>
                                    {{ $kelasItem }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4">
                        <input type="text" name="search" id="search" class="form-control w-100"
                            placeholder="Cari NIS atau Nama" value="{{ request('search') }}">
                    </div>

                    <div class="col-2">
                        <button class="btn btn-primary btn-sm w-100 mt-1" onclick="cariNasabah()">Cari</button>
                        <form action="{{ route('nasabah.index') }}" method="GET" id="formCari" style="display: none;">
                            <input type="hidden" name="kelas" id="kelasHidden">
                            <input type="hidden" name="search" id="searchHidden">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow rounded-3">
            <div class="card-body">
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
                                    <a href="{{ route('nasabah.edit', $nasabah->nis) }}" class="btn btn-warning btn-sm"><i
                                            class="bi bi-pencil-square"></i></a>

                                    <!-- Form Hapus dengan konfirmasi JavaScript -->
                                    <form action="{{ route('nasabah.destroy', $nasabah->nis) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Anda yakin ingin menghapus nasabah ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="bi bi-trash"></i></button>
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
    </style>
@endpush

@push('script')
    <script>
        // dt without seach and info
        $(document).ready(function() {
            var dt = $('#dtnasabah').DataTable({
                bInfo: false,
                pageLength: 10,
                lengthChange: false,
                deferRender: true,
                processing: true,
                oLanguage: {
                    "sSearch": "Cari Nasabah",
                    "sEmptyTable": "Tidak ada data nasabah.",
                    "sZeroRecords": "Tidak ada data nasabah.",
                },
            });
        });

        // cari nasabah
        function cariNasabah() {
            var kelas = document.getElementById('kelas').value;
            var search = document.getElementById('search').value;

            document.getElementById('kelasHidden').value = kelas;
            document.getElementById('searchHidden').value = search;

            document.getElementById('formCari').submit();
        }
    </script>
@endpush
