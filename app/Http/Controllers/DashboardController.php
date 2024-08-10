<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Aktifitas;
use Illuminate\Support\Facades\DB; // Tambahkan jika Anda menggunakan DB::transaction

class DashboardController extends Controller
{
    public function index()
    {
        $nasabahs = Nasabah::all(); // Ambil semua data nasabah
        return view('dashboard.index', compact('nasabahs'));
    }

    public function simpanSimpanan(Request $request)
    {
        $request->validate([
            'TxtNoRekening' => 'required|exists:nasabahs,nis', // Perbaiki nama tabel jika diperlukan
            'TxtNominalSimpanan' => 'required|numeric|min:0', // Tambahkan validasi minimal
        ]);

        DB::transaction(function() use ($request) {
            // Ambil data nasabah
            $nasabah = Nasabah::where('nis', $request->TxtNoRekening)->firstOrFail(); // Menggunakan firstOrFail

            // Update saldo nasabah
            $nasabah->saldo_total += $request->TxtNominalSimpanan;
            $nasabah->save();

            // Simpan aktivitas
            Aktifitas::create([
                'nis' => $request->TxtNoRekening,
                'jumlah' => $request->TxtNominalSimpanan,
                'tanggal' => now()->format('Y-m-d'),
                'jenis_aktifitas' => 'simpanan',
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Simpanan berhasil disimpan.');
    }

    public function simpanPenarikan(Request $request)
    {
        $request->validate([
            'TxtNoRekening' => 'required|exists:nasabahs,nis', // Perbaiki nama tabel jika diperlukan
            'TxtNominalPenarikan' => 'required|numeric|min:0', // Tambahkan validasi minimal
        ]);

        DB::transaction(function() use ($request) {
            // Ambil data nasabah
            $nasabah = Nasabah::where('nis', $request->TxtNoRekening)->firstOrFail(); // Menggunakan firstOrFail

            // Periksa saldo
            if ($nasabah->saldo_total < $request->TxtNominalPenarikan) {
                throw new \Exception('Saldo tidak cukup.');
            }

            // Update saldo nasabah
            $nasabah->saldo_total -= $request->TxtNominalPenarikan;
            $nasabah->save();

            // Simpan aktivitas
            Aktifitas::create([
                'nis' => $request->TxtNoRekening,
                'jumlah' => $request->TxtNominalPenarikan,
                'tanggal' => now()->format('Y-m-d'),
                'jenis_aktifitas' => 'penarikan',
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Penarikan berhasil disimpan.');
    }
}
