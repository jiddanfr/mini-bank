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
        // Ambil aktivitas terbaru per NIS dengan urutan tanggal yang benar
        $subQuery = DB::table('aktifitas')
            ->select('nis', 'jenis_aktifitas', 'jumlah', 'tanggal')
            ->orderBy('id', 'desc'); // Urutkan berdasarkan tanggal dalam subquery
        
        // Gabungkan dengan data nasabah dan pastikan urutan tanggal dalam hasil akhir
        $data = DB::table('datanasabah')
            ->leftJoinSub($subQuery, 'latest_activities', function($join) {
                $join->on('datanasabah.nis', '=', 'latest_activities.nis');
            })
            ->select(
                'datanasabah.nis',
                'datanasabah.nama',
                'datanasabah.kelas',
                DB::raw("GROUP_CONCAT(CONCAT(latest_activities.jenis_aktifitas, ': ', FORMAT(latest_activities.jumlah, 2), ' (', DATE_FORMAT(latest_activities.tanggal, '%d-%m-%Y'), ')') ORDER BY latest_activities.tanggal DESC SEPARATOR '| ') AS aktivitas_details"),
                'datanasabah.saldo_total'
            )
            ->groupBy('datanasabah.nis', 'datanasabah.nama', 'datanasabah.kelas', 'datanasabah.saldo_total')
            ->orderByRaw('FIELD(datanasabah.kelas, "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X")')
            ->paginate(10000); // Ambil 10000 data per halaman
        
        // Tampilkan halaman rekapan dengan data yang dipaginasi
        return view('rekapan.index', ['data' => $data]);
    }
    
    

    public function export()
    {
        // Ekspor data ke dalam format Excel
        return Excel::download(new RekapanExport, 'rekapan.xlsx');
    }
}
