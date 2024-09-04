<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Aktifitas;
use App\Models\PengaturanAdministrasi;
use Illuminate\Support\Facades\DB;

class SimpananController extends Controller
{
    public function simpanSimpanan(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'TxtNoRekening' => 'required|exists:datanasabah,nis',
            'TxtNominalSimpanan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);
    
        // Mulai transaksi
        DB::beginTransaction();
    
        try {
            // Ambil data nasabah
            $nasabah = Nasabah::where('nis', $validated['TxtNoRekening'])->first();
            if (!$nasabah) {
                return response()->json(['status' => 'error', 'message' => 'Nasabah tidak ditemukan.']);
            }
    
            // Ambil pengaturan administrasi
            $pengaturan = PengaturanAdministrasi::first();
            if (!$pengaturan) {
                return response()->json(['status' => 'error', 'message' => 'Pengaturan administrasi tidak ditemukan.']);
            }
    
            // Periksa apakah jumlah simpanan memenuhi minimal simpanan
            if ($validated['TxtNominalSimpanan'] < $pengaturan->minimal_simpanan) {
                return response()->json(['status' => 'error', 'message' => 'Jumlah simpanan tidak memenuhi minimal simpanan: ' . $pengaturan->minimal_simpanan]);
            }
    
            // Hitung total simpanan (jumlah yang disimpan - biaya penyimpanan)
            $totalSimpanan = $validated['TxtNominalSimpanan'] - $pengaturan->biaya_penyimpanan;
    
            // Update saldo nasabah dengan nominal simpanan
            $nasabah->saldo_total += $totalSimpanan;
            $nasabah->save();
    
            // Simpan aktivitas simpanan
            Aktifitas::create([
                'nis' => $validated['TxtNoRekening'],
                'jumlah' => $validated['TxtNominalSimpanan'],
                'tanggal' => now()->format('Y-m-d'),
                'jenis_aktifitas' => 'Simpan',
                'keterangan' => $validated['keterangan'] ?? 'Simpan',
            ]);
    
            // Hitung jumlah aktivitas untuk NIS yang sama
            $aktivitasCount = Aktifitas::where('nis', $validated['TxtNoRekening'])->count();
    
            // Ambil saldo terbaru
            $saldoTotal = $nasabah->saldo_total;
    
            // Commit transaksi jika semua berhasil
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Simpanan berhasil disimpan.',
                'saldo_total' => $saldoTotal, // Tambahkan saldo terbaru
                'aktivitas_count' => $aktivitasCount // Tambahkan jumlah aktivitas
            ]);
    
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan simpanan.']);
        }
    }
    

}