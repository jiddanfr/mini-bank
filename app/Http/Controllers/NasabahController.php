<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NasabahImport;

class NasabahController extends Controller
{
    public function index(Request $request)
    {
        $kelas = $request->input('kelas');
        $query = Nasabah::query();

        if ($kelas) {
            $query->where('kelas', $kelas);
        }

        $nasabahs = $query->get(); // Menggunakan get() untuk menampilkan data
        $kelasList = Nasabah::distinct()->pluck('kelas'); // Ambil daftar kelas yang unik

        return view('nasabah.index', compact('nasabahs', 'kelasList', 'kelas'));
    }

    public function create()
    {
        return view('nasabah.form');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nis' => 'required|unique:datanasabah|max:255',
            'nama' => 'required|max:255',
            'kelas' => 'required|max:255',
            'saldo_total' => 'required|numeric',
        ], [], [
            'nis' => 'NIS',
            'nama' => 'Nama',
            'kelas' => 'Kelas',
            'saldo_total' => 'Saldo Total',
        ]);

        Nasabah::create($validatedData);

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil ditambahkan.');
    }

    public function edit($nis)
{
    $nasabah = Nasabah::where('nis', $nis)->firstOrFail();
    return view('nasabah.edit', compact('nasabah')); // Pastikan ini mengarah ke view edit
}


public function update(Request $request, $nis)
{
    $validatedData = $request->validate([
        'nama' => 'required|max:255',
        'kelas' => 'required|max:255',
        'saldo_total' => 'required|numeric',
    ], [], [
        'nama' => 'Nama',
        'kelas' => 'Kelas',
        'saldo_total' => 'Saldo Total',
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
        $nasabah = Nasabah::where('nis', $nis)->firstOrFail();
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

        $nasabahs = $query->get(); // Menggunakan get() untuk menampilkan data

        return view('nasabah.index', compact('nasabahs'));
    }
}
