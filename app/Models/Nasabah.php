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


   

   
    // Scope untuk memfilter nasabah berdasarkan kelas
    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    // Scope untuk mencari nasabah berdasarkan NIS atau Nama
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('nis', 'LIKE', "%$searchTerm%")
                     ->orWhere('nama', 'LIKE', "%$searchTerm%");
    }
}
