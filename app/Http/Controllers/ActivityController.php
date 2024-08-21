<?php

namespace App\Http\Controllers;

use App\Models\Aktifitas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        // Membuat query dasar untuk model Aktifitas
        $query = Aktifitas::query();

        // Memeriksa apakah ada parameter 'search' yang diisi
        if ($request->filled('search')) {
            $search = $request->input('search');

            // Menggunakan 'where' dengan 'orWhere' untuk pencarian pada kolom NIS dan keterangan
            $query->where(function ($q) use ($search) {
                $q->where('nis', 'like', "%$search%")
                    ->orWhere('keterangan', 'like', "%$search%");
            });
        }

        // Mengambil data dengan urutan tanggal terbaru dan menggunakan paginasi
        $activities = $query->orderBy('id', 'desc')->paginate(10);

        // Mengirimkan data ke view
        return view('activities.index', compact('activities'));
    }


    public function generatePdf()
    {
        $activities = Aktifitas::orderBy('id', 'desc')->get();
        $pdf = Pdf::loadView('pdf.activities', compact('activities'));
        return $pdf->download('aktivitas.pdf');
    }
}
