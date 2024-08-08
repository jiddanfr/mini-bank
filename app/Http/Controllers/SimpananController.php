<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Aktifitas;
use App\Models\PengaturanAdministrasi;

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

        // Ambil data nasabah
        $nasabah = Nasabah::where('nis', $validated['TxtNoRekening'])->first();
        if (!$nasabah) {
            return redirect()->back()->withErrors(['msg' => 'Nasabah tidak ditemukan.']);
        }

        // Ambil pengaturan administrasi
        $pengaturan = PengaturanAdministrasi::first();
        if (!$pengaturan) {
            return redirect()->back()->withErrors(['msg' => 'Pengaturan administrasi tidak ditemukan.']);
        }

        // Hitung total simpanan (jumlah yang disimpan - biaya penyimpanan)
        $totalSimpanan = $validated['TxtNominalSimpanan'] - $pengaturan->biaya_penyimpanan;

        // Periksa apakah jumlah simpanan mencukupi
        if ($totalSimpanan < 0) {
            return redirect()->back()->withErrors(['msg' => 'Jumlah simpanan tidak mencukupi untuk menutupi biaya penyimpanan.']);
        }

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

        return redirect()->route('dashboard')->with('success', 'Simpanan berhasil disimpan.');
    }
}
