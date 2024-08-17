@extends('layouts.app')

@section('title', 'Aktivitas')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4">Data Aktivitas</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('activities.generatePdf') }}" class="btn btn-success btn-sm" style="padding-right: 15px;">
                    <i class="bi bi-file-earmark-pdf icon-bg"></i> Unduh PDF
                </a>
            </div>
        </div>

        <div class="card rounded-3 shadow-sm mb-4">
            <div class="card-body">
                <div class="row justify-content-between">
                    {{-- <div class="col-4">
                        <select name="kelas" id="kelas" class="form-control w-100" onchange="cariKelas(this.value)">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelasList as $kelasItem)
                                <option value="{{ $kelasItem }}" {{ $kelas == $kelasItem ? 'selected' : '' }}>
                                    {{ $kelasItem }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="col-4">
                        <input type="text" name="search" id="search" class="form-control w-100"
                            placeholder="Cari NIS atau Nama" value="{{ request('search') }}">
                    </div>

                    <div class="col-2">
                        <button class="btn btn-primary btn-sm w-100 mt-1" onclick="cariAktifitas()">Cari</button>
                        <form action="{{ route('activities.index') }}" method="GET" id="formCari" style="display: none;">
                            <input type="hidden" name="kelas" id="kelasHidden">
                            <input type="hidden" name="search" id="searchHidden">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Aktivitas -->
        <div class="card shadow rouded-3">
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dt">
                    <thead class="thead-dark">
                        <tr>
                            <th>NIS</th>
                            <th>Jenis Aktivitas</th>
                            <th>Jumlah (Rp)</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr>
                                <td>{{ $activity->nis }}</td>
                                <td>{{ $activity->jenis_aktifitas }}</td>
                                <td>{{ rupiah($activity->jumlah) }}</td>
                                <td>{{ $activity->keterangan }}</td>
                                <td>{{ $activity->tanggal->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data aktivitas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Menampilkan pagination dengan Bootstrap -->
        <div class="d-flex justify-content-center">
            {{ $activities->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
@endsection

@push('script')
    <script>
        function cariAktifitas() {
            // let kelas = document.getElementById('kelas').value;
            let search = document.getElementById('search').value;

            // document.getElementById('kelasHidden').value = kelas;
            document.getElementById('searchHidden').value = search;

            document.getElementById('formCari').submit();
        }
    </script>
@endpush
