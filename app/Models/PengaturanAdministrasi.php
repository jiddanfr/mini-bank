<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanAdministrasi extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_administrasi';

    // Tentukan kolom primary key
    protected $primaryKey = 'id';

    // Pastikan auto increment diaktifkan
    public $incrementing = true;

    // Nonaktifkan timestamp jika tidak digunakan
    public $timestamps = false;

    protected $fillable = [
        'biaya_penarikan',
        'biaya_penyimpanan',
        'administrasi_bulanan',
        'minimal_saldo_tarik',
    ];
}
