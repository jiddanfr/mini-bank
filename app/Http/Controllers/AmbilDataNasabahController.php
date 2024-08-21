<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Aktifitas;
use App\Models\PengaturanAdministrasi;
use Illuminate\Support\Facades\DB;

class AmbilDataNasabahController extends Controller
{
    public function ambilDataNasabah(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'TxtNoRekening' => 'required|exists:datanasabah,nis',
    ]);

    // Mulai transaksi
    DB::beginTransaction();

    try {
        // Ambil data nasabah
        $nasabah = Nasabah::where('nis', $validated['TxtNoRekening'])->first();
        if (!$nasabah) {
            return response()->json(['status' => 'error', 'message' => 'Nasabah tidak ditemukan.']);
        }

        return response()->json([
            'status' => 'success',
            'namanasabah' => $nasabah->nama,
            'kelasnasabah' => $nasabah->kelas
        ]);

    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan simpanan.']);
    }
}

}
