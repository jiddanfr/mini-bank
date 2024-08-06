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
        $request->validate([
            'TxtNoRekening' => 'required|exists:nasabah,nis',
            'TxtNominalSimpanan' => 'required|numeric|min:0',
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

        // Hitung total simpanan (jumlah yang disimpan + biaya penyimpanan)
        $totalSimpanan = $request->TxtNominalSimpanan - $pengaturan->biaya_penyimpanan;

        // Periksa saldo nasabah
        if ($totalSimpanan < 0) {
            return redirect()->back()->withErrors(['msg' => 'Jumlah simpanan tidak mencukupi untuk menutupi biaya penyimpanan.']);
        }

        // Update saldo nasabah dengan nominal simpanan
        $nasabah->saldo_total += $totalSimpanan;
        $nasabah->save();

        // Simpan aktivitas simpanan
        Aktifitas::create([
            'nis' => $request->TxtNoRekening,
            'jumlah' => $request->TxtNominalSimpanan,
            'tanggal' => now()->format('Y-m-d'),
            'jenis_aktifitas' => 'simpanan',
            'keterangan' => $request->keterangan ?? 'Simpan',
        ]);

        return redirect()->route('dashboard')->with('success', 'Simpanan berhasil disimpan.');
    }

    public function simpanSimpananCetak(Request $request)
    {
        $data = [
            'no_rekening' => $request->query('TxtNoRekening'),
            'nominal_simpanan' => $request->query('TxtNominalSimpanan'),
            'keterangan' => $request->query('keterangan'),
        ];

        return response()->json($data);
    }
}
