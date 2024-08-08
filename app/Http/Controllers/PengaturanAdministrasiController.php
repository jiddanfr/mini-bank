<?php
namespace App\Http\Controllers;

use App\Models\PengaturanAdministrasi;
use Illuminate\Http\Request;

class PengaturanAdministrasiController extends Controller
{
    public function index()
    {
        // Pastikan hanya ada satu entri dalam tabel
        $pengaturan = PengaturanAdministrasi::firstOrCreate(
            [], // Kondisi kosong karena kita hanya ingin memastikan satu entri
            [
                'biaya_penarikan' => 0,
                'biaya_penyimpanan' => 0,
                'administrasi_bulanan' => 0,
                'minimal_saldo_tarik' => 0,
            ]
        );

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

        // Ambil entri pengaturan administrasi yang ada
        $pengaturan = PengaturanAdministrasi::firstOrFail();

        // Update pengaturan administrasi dengan data dari request
        $pengaturan->update($request->only([
            'biaya_penarikan',
            'biaya_penyimpanan',
            'administrasi_bulanan',
            'minimal_saldo_tarik',
        ]));

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan berhasil diperbarui');
    }
}
