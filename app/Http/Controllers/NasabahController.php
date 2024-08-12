<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NasabahImport;

class NasabahController extends Controller
{
    public function index(Request $request)
    {
        $kelas = $request->input('kelas');
    
        if ($kelas) {
            $nasabahs = Nasabah::where('kelas', $kelas)->get(); // Ganti paginate dengan get()
        } else {
            $nasabahs = Nasabah::all(); // Ganti paginate dengan all()
        }
    
        $kelasList = Nasabah::distinct()->pluck('kelas'); // Ambil daftar kelas yang unik
    
        return view('nasabah.index', compact('nasabahs', 'kelasList', 'kelas'));
    }
    


    public function create()
    {
        return view('nasabah.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nis' => 'required|unique:nasabahs|max:255',
            'nama' => 'required|max:255',
            'kelas' => 'required|max:255',
            'saldo_total' => 'required|numeric',
        ]);

        Nasabah::create($validatedData);

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil ditambahkan.');
    }

    public function edit($nis)
    {
        $nasabah = Nasabah::where('nis', $nis)->firstOrFail();
        return view('nasabah.edit', compact('nasabah'));
    }

    public function update(Request $request, $nis)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'kelas' => 'required|max:255',
            'saldo_total' => 'required|numeric',
        ]);

        $nasabah = Nasabah::where('nis', $nis)->firstOrFail();
        $nasabah->update($validatedData);

        return redirect()->route('nasabah.index')->with('success', 'Data nasabah berhasil diperbarui.');
    }

    public function checkNis($nis)
    {
        $exists = Nasabah::where('nis', $nis)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new NasabahImport, $request->file('file'));
            return redirect()->route('nasabah.index')->with('success', 'Data Nasabah berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('nasabah.index')->with('error', 'Terjadi kesalahan saat mengimport data.');
        }
    }

    public function destroy($nis)
    {
        $nasabah = Nasabah::where('nis', $nis)->first();
        
        if (!$nasabah) {
            return redirect()->route('nasabah.index')->with('error', 'Nasabah tidak ditemukan.');
        }

        $nasabah->delete();

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil dihapus.');
    }

    public function search(Request $request)
{
    $query = Nasabah::query();

    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $query->where('nis', 'LIKE', "%$searchTerm%")
              ->orWhere('nama', 'LIKE', "%$searchTerm%");
    }

    $nasabahs = $query->get(); // Ganti paginate dengan get()

    return view('nasabah.index', compact('nasabahs'));
}

}
