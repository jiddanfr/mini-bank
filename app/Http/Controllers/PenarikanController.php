<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Aktifitas;
use App\Models\PengaturanAdministrasi;
use Illuminate\Support\Facades\DB;

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
                return redirect()->back()->withErrors(['msg' => 'Pengaturan administrasi tidak ditemukan.']);
            }

            // Periksa apakah jumlah penarikan memenuhi minimal penarikan
            if ($validated['TxtNominalPenarikan'] < $pengaturan->minimal_saldo_tarik) {
                return redirect()->back()->withErrors(['msg' => 'Jumlah penarikan tidak memenuhi batas minimal penarikan: ' . $pengaturan->minimal_saldo_tarik]);
            }

            // Hitung total penarikan (jumlah yang ingin ditarik + biaya penarikan)
            $totalPenarikan = $validated['TxtNominalPenarikan'] + $pengaturan->biaya_penarikan;

            // Periksa saldo nasabah
            if ($nasabah->saldo_total - $totalPenarikan < $pengaturan->minimal_jumlah_saldo) {
                return redirect()->back()->withErrors(['msg' => 'Saldo tidak cukup untuk penarikan. Minimal saldo yang harus ada setelah penarikan adalah ' . $pengaturan->minimal_jumlah_saldo]);
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

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Penarikan berhasil disimpan.');

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            return redirect()->back()->withErrors(['msg' => 'Terjadi kesalahan saat menyimpan penarikan.']);
        }
    }
    
}
