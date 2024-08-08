<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
    use HasFactory;

    protected $table = 'aktifitas'; // Pastikan tabel yang digunakan sesuai dengan nama tabel di database

    protected $fillable = [
        'nis',
        'jumlah',
        'tanggal',
        'jenis_aktifitas',
        'keterangan', 
    ];

    protected $casts = [
        'tanggal' => 'date', // Casting tanggal ke tipe date
        'jumlah' => 'decimal:2', // Pastikan jumlah disimpan sebagai decimal jika diperlukan
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nis', 'nis');
    }
}
