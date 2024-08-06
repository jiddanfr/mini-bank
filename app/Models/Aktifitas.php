<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'jumlah',
        'tanggal',
        'jenis_aktifitas',
        'keterangan', 
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
