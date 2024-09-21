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
            ->select('bulan', 'tahun', DB::raw('saldo_akhir as saldo_awal'))
            ->whereYear('created_at', date('Y') - 1)
            ->get()
            ->keyBy('bulan'); // Menggunakan bulan sebagai kunci, jika relevan
    
        // Query utama untuk mengambil data nasabah dengan aktifitas
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
            // Gunakan bulan jika diperlukan, atau hapus jika tidak relevan
            $previousYearSaldo = $previousYearSaldoQuery->get($nasabah->nis); // Atau gunakan kunci lain jika relevan
            $nasabah->saldo_awal = $previousYearSaldo ? $previousYearSaldo->saldo_awal : 0;
            $nasabah->saldo_akhir = $nasabah->saldo_total;
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

public function storeRekapanYearly(Request $request)
{
    DB::beginTransaction();

    try {
        // Hapus data lama dari tabel aktifitas
        DB::table('aktifitas')->truncate();

        // Ambil data rekapan tahunan dari tabel datanasabah
        $rekapanData = DB::table('datanasabah')
            ->select(
                DB::raw('YEAR(now()) as tahun'),
                DB::raw('SUM(saldo_total) as saldo_total')
            )
            ->groupBy(DB::raw('YEAR(now())'))
            ->get();

        // Hapus data lama dari tabel rekapan sebelum menyimpan yang baru
        DB::table('rekapan')->truncate();

        // Menyimpan data rekapan tahunan ke tabel rekapan
        foreach ($rekapanData as $rekapan) {
            DB::table('rekapan')->insert([
                'bulan' => date('m'),
                'tahun' => $rekapan->tahun,
                'total_simpanan' => 0,
                'total_penarikan' => 0,
                'saldo_awal' => $rekapan->saldo_total,
                'saldo_akhir' => $rekapan->saldo_total,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::commit();

        // Siapkan nama file untuk ekspor
        $fileName = 'rekapan_tahunan_' . date('Y') . '.xlsx';
        $export = new RekapanExport;

        // Simpan file Excel di storage
        Excel::store($export, 'public/' . $fileName);

        // Siapkan path file untuk diunduh
        $filePath = storage_path('app/public/' . $fileName);

        // Unduh file dan hapus setelah pengiriman
        return response()->download($filePath)->deleteFileAfterSend(true);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal menyimpan rekapan tahunan: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal menyimpan rekapan tahunan: ' . $e->getMessage());
    }
}



    
    

    


    public function showRiwayatRekapan()
{
    $riwayatRekapan = DB::table('riwayatrekapan')->paginate(10);
    
    return view('riwayat_rekapan.index', ['riwayatRekapan' => $riwayatRekapan]);
}

}