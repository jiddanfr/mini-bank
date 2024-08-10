@extends('layouts.app')

@section('title', 'Aktivitas')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Aktivitas</h1>

    <!-- Pencarian -->
    <form method="GET" action="{{ route('activities.index') }}" class="mb-4">
        <div class="form-row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari NIS atau Keterangan" value="{{ request()->get('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>

    <!-- Unduh PDF -->
    @if($activities->count() > 0)
        <a href="{{ route('activities.generatePdf') }}" class="btn btn-success mb-4">Unduh PDF</a>
    @endif

    <!-- Tabel Aktivitas -->
    <table class="table table-bordered table-striped">
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
                    <td>{{ number_format($activity->jumlah, 0, ',', '.') }}</td>
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
@endsection
