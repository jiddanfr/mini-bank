<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class RekapanExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return DB::table('datanasabah')
            ->leftJoin('aktifitas', 'datanasabah.nis', '=', 'aktifitas.nis')
            ->select(
                'datanasabah.nis',
                'datanasabah.nama',
                'datanasabah.kelas',
                DB::raw("GROUP_CONCAT(CONCAT(aktifitas.jenis_aktifitas, ': ', FORMAT(aktifitas.jumlah, 2), ' (', DATE_FORMAT(aktifitas.tanggal, '%Y-%m-%d'), ')') SEPARATOR '; ') AS aktivitas_details"),
                DB::raw('FORMAT(datanasabah.saldo_total, 2) AS saldo_total')
            )
            ->groupBy('datanasabah.nis', 'datanasabah.nama', 'datanasabah.kelas', 'datanasabah.saldo_total')
            ->orderByRaw('FIELD(datanasabah.kelas, "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X")'); // Mengurutkan berdasarkan kelas
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama',
            'Kelas',
            'Aktivitas',
            'Saldo Total',
        ];
    }

    public function map($row): array
    {
        return [
            $row->nis,
            $row->nama,
            $row->kelas,
            $row->aktivitas_details,
            $row->saldo_total,
        ];
    }
}
