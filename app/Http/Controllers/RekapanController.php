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
            ->select('nis', DB::raw('saldo_akhir as saldo_awal'))
            ->whereYear('created_at', date('Y') - 1)
            ->get()
            ->keyBy('nis');

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
                ) AS aktivitas_details")
            )
            ->groupBy('datanasabah.nis', 'datanasabah.nama', 'datanasabah.kelas')
            ->get();

        // Menambahkan saldo awal ke setiap nasabah berdasarkan tahun sebelumnya
        foreach ($data as $nasabah) {
            $nasabah->saldo_awal = isset($previousYearSaldoQuery[$nasabah->nis]) ? $previousYearSaldoQuery[$nasabah->nis]->saldo_awal : 0;
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

    public function storeYearlyRekapan(Request $request)
{
    // Mengambil data rekapan tahunan dari tabel datanasabah
    $rekapanData = DB::table('datanasabah')
        ->select(
            DB::raw('YEAR(now()) as tahun'),
            DB::raw('SUM(saldo_total) as saldo_awal'),
            DB::raw('SUM(saldo_total) as saldo_akhir')
        )
        ->groupBy(DB::raw('YEAR(now())'))
        ->get();

    DB::beginTransaction();

    try {
        // Menghapus data lama dari tabel rekapan
        DB::table('rekapan')->truncate();

        // Menyimpan data rekapan tahunan ke tabel rekapan
        foreach ($rekapanData as $rekapan) {
            DB::table('rekapan')->insert([
                'bulan' => date('m'), // atau bulan yang relevan
                'tahun' => $rekapan->tahun,
                'total_simpanan' => 0, // Setel ke 0 jika tidak ada data
                'total_penarikan' => 0, // Setel ke 0 jika tidak ada data
                'saldo_awal' => $rekapan->saldo_awal,
                'saldo_akhir' => $rekapan->saldo_akhir,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::commit();

        $fileName = 'rekapan_tahunan_' . date('Y') . '.xlsx';
        $export = new RekapanExport;

        Excel::store($export, 'public/' . $fileName);

        $filePath = storage_path('app/public/' . $fileName);

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
