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
                'minimal_jumlah_saldo' => 0, // Pastikan ini ditambahkan
                'minimal_simpanan' => 0,      // Pastikan ini ditambahkan
            ]
        );

        return view('pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'biaya_penarikan' => 'required|integer|min:0',
            'biaya_penyimpanan' => 'required|integer|min:0',
            'administrasi_bulanan' => 'required|integer|min:0',
            'minimal_saldo_tarik' => 'required|integer|min:0',
            'minimal_jumlah_saldo' => 'required|integer|min:0', // Tambahkan validasi ini
            'minimal_simpanan' => 'required|integer|min:0',      // Tambahkan validasi ini
        ]);

        // Ambil entri pengaturan administrasi yang ada
        $pengaturan = PengaturanAdministrasi::firstOrFail();

        // Update pengaturan administrasi dengan data dari request
        $pengaturan->update($request->only([
            'biaya_penarikan',
            'biaya_penyimpanan',
            'administrasi_bulanan',
            'minimal_saldo_tarik',
            'minimal_jumlah_saldo', // Tambahkan kolom ini
            'minimal_simpanan',     // Tambahkan kolom ini
        ]));

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan berhasil diperbarui');
    }
}
