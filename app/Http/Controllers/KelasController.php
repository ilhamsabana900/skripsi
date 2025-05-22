<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::query();
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama_kelas', 'like', "%$q%") ;
        }
        $kelas = $query->paginate(10);
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
        ]);
        Kelas::create($request->only(['nama_kelas']));
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $id,
        ]);
        $kelas->update($request->only(['nama_kelas']));
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diupdate.');
    }

    public function destroy($id)
    {
        Kelas::destroy($id);
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
