<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapanExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return DB::table('datanasabah')
            ->leftJoin('aktifitas', 'datanasabah.nis', '=', 'aktifitas.nis')
            ->select(
                'datanasabah.nis',
                'datanasabah.nama',
                'datanasabah.kelas',
                DB::raw("GROUP_CONCAT(CONCAT(aktifitas.jenis_aktifitas, ': ', FORMAT(aktifitas.jumlah, 2), ' (', DATE_FORMAT(aktifitas.tanggal, '%d-%m-%Y'), ')') SEPARATOR '\r\n ') AS aktivitas_details"),
                DB::raw('FORMAT(datanasabah.saldo_total, 2) AS saldo_total')
            )
            ->groupBy('datanasabah.nis', 'datanasabah.nama', 'datanasabah.kelas', 'datanasabah.saldo_total')
            ->orderByRaw('FIELD(datanasabah.kelas, "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X")');
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

    public function styles(Worksheet $sheet)
    {
        // Mendapatkan seluruh cell range
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        // Mengatur wrap text, top alignment, dan border untuk semua cell
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
            'alignment' => [
                'wrapText' => true,
                'vertical' => Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Warna border hitam
                ],
            ],
        ]);

        // Mengatur autosize untuk semua kolom
        foreach (range('A', $highestColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }

    
}