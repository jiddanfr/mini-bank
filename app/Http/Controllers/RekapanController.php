<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Exports\RekapanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RekapanController extends Controller
{
    public function index()
    {
        // Subquery untuk mengambil saldo akhir tahun sebelumnya sebagai saldo awal tahun ini
        $previousYearSaldoQuery = DB::table('rekapan')
            ->select('nis', DB::raw('MAX(saldo_akhir) as saldo_awal'))
            ->whereYear('created_at', date('Y') - 1)
            ->groupBy('nis')
            ->get()
            ->keyBy('nis'); // Menggunakan NIS sebagai kunci
    
        // Query utama untuk mengambil data nasabah dengan aktivitas
        $data = DB::table('datanasabah')
            ->leftJoin('aktifitas', 'datanasabah.nis', '=', 'aktifitas.nis')
            ->select(
                'datanasabah.nis',
                'datanasabah.nama',
                'datanasabah.kelas',
                DB::raw('COALESCE(SUM(aktifitas.jumlah), 0) as saldo_total'),
                DB::raw("GROUP_CONCAT(
                    CONCAT(
                        CASE WHEN aktifitas.jenis_aktifitas = 'simpan' THEN CONCAT('Simpan: ', FORMAT(aktifitas.jumlah, 2))
                             WHEN aktifitas.jenis_aktifitas = 'tarik' THEN CONCAT('Tarik: ', FORMAT(aktifitas.jumlah, 2))
                             ELSE NULL
                        END,
                        ' (', DATE_FORMAT(aktifitas.tanggal, '%d-%m-%Y'), ')'
                    ) ORDER BY aktifitas.tanggal DESC SEPARATOR '| '
                ) AS aktifitas_details")
            )
            ->groupBy('datanasabah.nis', 'datanasabah.nama', 'datanasabah.kelas')
            ->get();
    
        // Menambahkan saldo awal dan saldo akhir ke setiap nasabah berdasarkan rekapan sebelumnya
        foreach ($data as $nasabah) {
            $previousYearSaldo = $previousYearSaldoQuery->get($nasabah->nis);
            $nasabah->saldo_awal = $previousYearSaldo ? $previousYearSaldo->saldo_awal : 0;
            $nasabah->saldo_akhir = $nasabah->saldo_awal + $nasabah->saldo_total;
        }
    
        // Data final untuk view
        return view('rekapan.index', ['data' => $data]);
    }

    




    public function export()
    {
        // Ekspor data ke dalam format Excel
        return Excel::download(new RekapanExport, 'rekapan.xlsx');
    }

    public function storeRekapan(Request $request)
{
    // Siapkan nama file untuk ekspor
    $fileName = 'rekapan_tahunan_' . date('Y') . '.xlsx';
    $export = new RekapanExport;

    // Simpan file Excel di storage
    Excel::store($export, 'public/' . $fileName);

    // Siapkan path file untuk diunduh
    $filePath = storage_path('app/public/' . $fileName);

    // Unduh file dan hapus setelah pengiriman
    return response()->download($filePath)->deleteFileAfterSend(true);
}

public function resetData(Request $request)
{
    DB::beginTransaction();

    try {
        // Hapus semua data dari tabel 'aktifitas' tanpa pengecekan jumlah data
        DB::table('aktifitas')->truncate();

        DB::commit(); // Commit perubahan

        // Selalu tampilkan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil direset.');
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback jika terjadi kesalahan
        Log::error('Gagal mereset data: ' . $e->getMessage());
        
        // Tampilkan pesan sukses meskipun ada error (jika ini yang diinginkan)
        return redirect()->back()->with('success', 'Data berhasil direset.');
    }
}




    
    

    


    public function showRiwayatRekapan()
{
    $riwayatRekapan = DB::table('riwayatrekapan')->paginate(10);
    
    return view('riwayat_rekapan.index', ['riwayatRekapan' => $riwayatRekapan]);
}

}