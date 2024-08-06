<?php
namespace App\Http\Controllers;

use App\Models\Aktifitas;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function simpanDanCetak(Request $request)
{
    $request->validate([
        'TxtNoRekening' => 'required|integer',
        'TxtNominalSimpanan' => 'nullable|numeric',
        'TxtNominalPenarikan' => 'nullable|numeric',
        'keterangan' => 'nullable|string',
        'jenis' => 'required|in:simpanan,penarikan',
    ]);

    $data = $request->only(['TxtNoRekening', 'TxtNominalSimpanan', 'TxtNominalPenarikan', 'keterangan']);
    $jenis = $request->input('jenis');

    // Simpan aktivitas ke database
    $activity = new Aktifitas();
    $activity->nasabah_id = $data['TxtNoRekening'];
    $activity->nominal = $jenis === 'simpanan' ? $data['TxtNominalSimpanan'] : $data['TxtNominalPenarikan'];
    $activity->keterangan = $data['keterangan'];
    $activity->jenis_aktifitas = $jenis === 'simpanan' ? 'Simpanan' : 'Penarikan';
    $activity->save();

    // Cetak halaman jika jenis 'simpanan' atau 'penarikan'
    return view('print-activity', compact('activity'));
}

}
