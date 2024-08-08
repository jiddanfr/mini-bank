@extends('layouts.app')

@section('title', 'Rekapan')

@section('content')
<div class="container">
    <h1 class="my-4">Rekapan Aktivitas</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Aktivitas</th>
                <th>Saldo Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $aktivitas)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $aktivitas->nis }}</td>
                <td>{{ $aktivitas->nama }}</td>
                <td>{{ $aktivitas->kelas }}</td>
                <td>{{ $aktivitas->aktivitas_details }}</td>
                <td>{{ $aktivitas->saldo_total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('rekapan.export') }}" class="btn btn-success">Download Rekapan (Excel)</a>
</div>
@endsection
