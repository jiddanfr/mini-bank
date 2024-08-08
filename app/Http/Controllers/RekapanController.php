<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Aktifitas;
use App\Models\PengaturanAdministrasi;
use Illuminate\Support\Facades\DB;
use App\Exports\RekapanExport;
use Maatwebsite\Excel\Facades\Excel;

class RekapanController extends Controller
{
    public function index()
    {
        // Ambil data aktivitas dengan penggabungan per NIS
        $data = DB::table('datanasabah')
            ->leftJoin('aktifitas', 'datanasabah.nis', '=', 'aktifitas.nis')
            ->select(
                'datanasabah.nis',
                'datanasabah.nama',
                'datanasabah.kelas',
                DB::raw("GROUP_CONCAT(CONCAT(aktifitas.jenis_aktifitas, ': ', FORMAT(aktifitas.jumlah, 2), ' (', DATE_FORMAT(aktifitas.tanggal, '%Y-%m-%d'), ')') SEPARATOR '; ') AS aktivitas_details"),
                DB::raw('FORMAT(datanasabah.saldo_total, 2) AS saldo_total')
            )
            ->groupBy('datanasabah.nis', 'datanasabah.nama', 'datanasabah.kelas', 'datanasabah.saldo_total')
            ->orderByRaw('FIELD(datanasabah.kelas, "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X")') // Mengurutkan berdasarkan kelas dalam angka Romawi
            ->get();

        // Tampilkan halaman rekapan
        return view('rekapan.index', compact('data'));
    }

    public function export()
    {
        // Ekspor data ke dalam format Excel
        return Excel::download(new RekapanExport, 'rekapan.xlsx');
    }
}
