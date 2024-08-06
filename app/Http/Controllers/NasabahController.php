<?php
namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    public function index()
    {
        $nasabahs = Nasabah::all(); // Mengambil semua data nasabah
        return view('nasabah.index', compact('nasabahs'));
    }
    public function create()
{
    return view('nasabah.create');
}

public function store(Request $request)
{
    $nasabah = Nasabah::create($request->all());
    return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil ditambahkan.');
}

public function edit($nis)
{
    $nasabah = Nasabah::findOrFail($nis);
    return view('nasabah.edit', compact('nasabah'));
}

public function update(Request $request, $nis)
{
    $nasabah = Nasabah::findOrFail($nis);
    $nasabah->update($request->all());
    return redirect()->route('nasabah.index')->with('success', 'Data nasabah berhasil diperbarui.');
}
public function checkNis($nis)
{
    $exists = Nasabah::where('nis', $nis)->exists();
    return response()->json(['exists' => $exists]);
}


}
