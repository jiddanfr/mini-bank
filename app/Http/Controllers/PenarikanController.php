<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Aktifitas;
use App\Models\PengaturanAdministrasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenarikanController extends Controller
{
    public function simpanPenarikan(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'TxtNoRekening' => 'required|exists:datanasabah,nis',
        'TxtNominalPenarikan' => 'required|numeric|min:0',
        'keterangan' => 'nullable|string',
    ]);

    // Mulai transaksi
    DB::beginTransaction();

    try {
        // Ambil data nasabah
        $nasabah = Nasabah::where('nis', $validated['TxtNoRekening'])->firstOrFail();

        // Ambil pengaturan administrasi
        $pengaturan = PengaturanAdministrasi::first();
        if (!$pengaturan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengaturan administrasi tidak ditemukan.'
            ]);
        }

        // Periksa apakah jumlah penarikan memenuhi minimal penarikan
        if ($validated['TxtNominalPenarikan'] < $pengaturan->minimal_saldo_tarik) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jumlah penarikan tidak memenuhi batas minimal penarikan: ' . $pengaturan->minimal_saldo_tarik
            ]);
        }

        // Hitung total penarikan (jumlah yang ingin ditarik + biaya penarikan)
        $totalPenarikan = $validated['TxtNominalPenarikan'] + $pengaturan->biaya_penarikan;

        // Periksa saldo nasabah
        if ($nasabah->saldo_total - $totalPenarikan < $pengaturan->minimal_jumlah_saldo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Saldo tidak cukup untuk penarikan. Minimal saldo yang harus ada setelah penarikan adalah ' . $pengaturan->minimal_jumlah_saldo
            ]);
        }

        // Update saldo nasabah
        $nasabah->saldo_total -= $totalPenarikan;
        $nasabah->save();

        // Simpan aktivitas penarikan
        Aktifitas::create([
            'nis' => $validated['TxtNoRekening'],
            'jumlah' => $validated['TxtNominalPenarikan'],
            'tanggal' => now()->format('Y-m-d'),
            'jenis_aktifitas' => 'Tarik',
            'keterangan' => $validated['keterangan'] ?? 'Tarik',
        ]);

        // Hitung jumlah aktivitas untuk NIS yang sama
        $aktivitasCount = Aktifitas::where('nis', $validated['TxtNoRekening'])->count();

        // Commit transaksi jika semua berhasil
        DB::commit();

        // Mengembalikan response JSON termasuk saldo_total yang terbaru
        return response()->json([
            'status' => 'success',
            'message' => 'Penarikan berhasil disimpan.',
            'aktivitas_count' => $aktivitasCount, // Jumlah aktivitas
            'saldo_total' => $nasabah->saldo_total // Tambahkan saldo_total terbaru
        ]);

    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollBack();
        
        // Log kesalahan
        Log::error('Kesalahan saat menyimpan penarikan: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menyimpan penarikan.'
        ]);
    }
}

}
