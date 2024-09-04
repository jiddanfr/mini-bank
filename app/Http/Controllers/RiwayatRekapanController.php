<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatRekapan; // Model untuk data riwayat rekapan

class RiwayatRekapanController extends Controller
{
    public function index()
    {
        // Ambil data riwayat rekapan dari database
        $riwayatRekapan = RiwayatRekapan::all(); // Kamu bisa menambahkan filter atau paging jika diperlukan

        // Kirim data ke view
        return view('riwayat_rekapan.index', ['riwayatRekapan' => $riwayatRekapan]);
    }
}
