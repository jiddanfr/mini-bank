<?php

namespace App\Imports;

use App\Models\Nasabah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class NasabahImport implements ToModel
{
    use Importable;

    public function model(array $row)
    {
        return new Nasabah([
            'nis' => $row[0],
            'nama' => $row[1],
            'kelas' => $row[2],
            'saldo_total' => (int) $row[3], // Menggunakan integer untuk saldo_total
        ]);
    }
}

