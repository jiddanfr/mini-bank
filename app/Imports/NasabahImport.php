<?php

namespace App\Imports;

use App\Models\Nasabah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NasabahImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        return new Nasabah([
            'nis' => $row['nis'],
            'nama' => $row['nama'],
            'kelas' => $row['kelas'],
            'saldo_total' => 0, // Set saldo_total to 0
        ]);
    }
}
