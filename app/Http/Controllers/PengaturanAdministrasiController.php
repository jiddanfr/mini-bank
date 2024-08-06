<?php

namespace App\Http\Controllers;

use App\Models\PengaturanAdministrasi;
use Illuminate\Http\Request;

class PengaturanAdministrasiController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanAdministrasi::firstOrCreate([
            // Opsional: kondisi jika Anda ingin memastikan hanya satu entri
        ]);

        return view('pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'biaya_penarikan' => 'required|numeric|min:0',
            'biaya_penyimpanan' => 'required|numeric|min:0',
            'administrasi_bulanan' => 'required|numeric|min:0',
            'minimal_saldo_tarik' => 'required|numeric|min:0',
        ]);

        $pengaturan = PengaturanAdministrasi::first();
        if (!$pengaturan) {
            return redirect()->route('pengaturan.index')->with('error', 'Pengaturan Administrasi tidak ditemukan.');
        }
        $pengaturan->update($request->all());

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan berhasil diperbarui');
    }
}
