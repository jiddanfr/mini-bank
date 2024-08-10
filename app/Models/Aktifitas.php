<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
    use HasFactory;

    protected $table = 'aktifitas';

    protected $fillable = [
        'nis',
        'jenis_aktifitas',
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'integer',
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nis', 'nis');
    }
}
