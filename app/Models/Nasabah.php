<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $table = 'datanasabah';
    protected $primaryKey = 'nis'; // Primary key
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Key type is string
    public $timestamps = false; // Menonaktifkan timestamps jika tabel tidak memiliki kolom created_at dan updated_at

    protected $fillable = ['nis', 'nama', 'kelas', 'saldo_total'];

    // Casting jika diperlukan, misalnya untuk saldo_total sebagai integer
    protected $casts = [
        'saldo_total' => 'integer',
    ];

    // Relasi dengan PengaturanAdministrasi
    public function pengaturanAdministrasi()
    {
        return $this->hasOne(PengaturanAdministrasi::class, 'nis', 'nis');
    }
}
