@extends('layouts.app')

@section('title', 'Rekapan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Rekapan Aktivitas</h2>
        
        <!-- Form untuk Simpan dan Unduh Rekapan Tahunan -->
        <form action="{{ route('rekapan.storeRekapan') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">Unduh Rekapan</button>
        </form>

        <form action="{{ route('rekapan.resetData') }}" method="POST" class="d-inline" onsubmit="resetAllActivityIndex()">
    @csrf
    <button type="submit" class="btn btn-danger">Reset Data</button>
</form>

<script>
    function resetAllActivityIndex() {
        // Loop melalui semua item di localStorage
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);

            // Jika kunci diawali dengan 'activityIndex_'
            if (key.startsWith('activityIndex_')) {
                localStorage.removeItem(key);
                
            }
        }

        console.log("Semua Activity Index telah direset.");
    }
</script>


    </div>

    @if($data->isEmpty())
        <div class="alert alert-warning" role="alert">
            Tidak ada data rekapan untuk ditampilkan.
        </div>
    @else
        <div class="card shadow rounded-3">
            <div class="card-body">
                <table class="table table-striped" id="dt">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Saldo Awal</th>
                            <th>Saldo Total</th>
                            <th>Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $nasabah)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $nasabah->nis }}</td>
                                <td>{{ $nasabah->nama }}</td>
                                <td>{{ $nasabah->kelas }}</td>
                                <td>{{ rupiah($nasabah->saldo_awal) }}</td>
                                <td>{{ rupiah($nasabah->saldo_total) }}</td>
                                <td>
                                    @if (!empty($nasabah->aktivitas_details))
                                        {!! nl2br(e(str_replace('|', "\n", $nasabah->aktivitas_details))) !!}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
