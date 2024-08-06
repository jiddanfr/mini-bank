<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanAdministrasi extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'pengaturan_administrasi'; // Sesuaikan dengan nama tabel yang benar

    public $incrementing = false; // Tidak menggunakan auto-increment

    protected $fillable = [
        'biaya_penarikan',
        'biaya_penyimpanan',
        'administrasi_bulanan',
        'minimal_saldo_tarik',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->biaya_penarikan = $model->biaya_penarikan ?? 0;
            $model->biaya_penyimpanan = $model->biaya_penyimpanan ?? 0;
            $model->administrasi_bulanan = $model->administrasi_bulanan ?? 0;
            $model->minimal_saldo_tarik = $model->minimal_saldo_tarik ?? 0;
        });
    }
}
