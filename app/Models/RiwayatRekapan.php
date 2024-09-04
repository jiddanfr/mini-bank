<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatRekapan extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'riwayatrekapan';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'bulan', 'tahun', 'total_simpanan', 'total_penarikan', 'saldo_awal', 'saldo_akhir'
    ];
}

