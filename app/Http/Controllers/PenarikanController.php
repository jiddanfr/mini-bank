<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Aktifitas;
use App\Models\PengaturanAdministrasi;

class PenarikanController extends Controller
{
    public function simpanPenarikan(Request $request)
    {
        // Validasi input
        $request->validate([
            'TxtNoRekening' => 'required|exists:nasabah,nis', // Pastikan nama tabel dan kolom benar
            'TxtNominalPenarikan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Ambil data nasabah
        $nasabah = Nasabah::where('nis', $request->TxtNoRekening)->first();
        if (!$nasabah) {
            return redirect()->back()->withErrors(['msg' => 'Nasabah tidak ditemukan.']);
        }

        // Ambil pengaturan administrasi
        $pengaturan = PengaturanAdministrasi::first();
        if (!$pengaturan) {
            return redirect()->back()->withErrors(['msg' => 'Pengaturan administrasi tidak ditemukan.']);
        }

        // Hitung total penarikan (jumlah yang ingin ditarik + biaya penarikan)
        $totalPenarikan = $request->TxtNominalPenarikan + $pengaturan->biaya_penarikan;

        // Periksa saldo
        if ($nasabah->saldo_total < $totalPenarikan) {
            return redirect()->back()->withErrors(['msg' => 'Saldo tidak cukup untuk penarikan dan biaya.']);
        }

        // Update saldo nasabah
        $nasabah->saldo_total -= $totalPenarikan;
        $nasabah->save();

        // Simpan aktivitas
        Aktifitas::create([
            'nis' => $request->TxtNoRekening,
            'jumlah' => $request->TxtNominalPenarikan,
            'tanggal' => now()->format('Y-m-d'),
            'jenis_aktifitas' => 'penarikan',
            'keterangan' => $request->keterangan ?? 'Tarik',
        ]);

        return redirect()->route('dashboard')->with('success', 'Penarikan berhasil disimpan.');
    }

    public function penarikanCetak(Request $request)
    {
        // Ambil data dari query
        $data = [
            'no_rekening' => $request->query('TxtNoRekening'),
            'nominal_penarikan' => $request->query('TxtNominalPenarikan'),
            'keterangan' => $request->query('keterangan'),
        ];

        return response()->json($data);
    }
}
