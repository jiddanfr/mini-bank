<?php

namespace App\Http\Controllers;

use App\Models\Aktifitas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        // Menambahkan pencarian jika ada parameter 'search'
        $query = Aktifitas::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nis', 'like', "%$search%")
                  ->orWhere('keterangan', 'like', "%$search%");
        }

        $activities = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('activities.index', compact('activities'));
    }

    public function generatePdf()
    {
        $activities = Aktifitas::orderBy('tanggal', 'desc')->get();
        $pdf = Pdf::loadView('pdf.activities', compact('activities'));
        return $pdf->download('aktivitas.pdf');
    }
}
