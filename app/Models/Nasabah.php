<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $table = 'datanasabah';
    protected $primaryKey = 'nis'; // Primary key
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Key type is string
    protected $fillable = ['nis', 'nama', 'kelas', 'saldo_total'];

    public function pengaturanAdministrasi()
    {
        return $this->hasOne(PengaturanAdministrasi::class, 'nis', 'nis');
    }
}
