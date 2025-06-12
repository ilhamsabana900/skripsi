<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with('mapels');
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama', 'like', "%$q%")
                  ->orWhere('email', 'like', "%$q%")
                  ->orWhereHas('mapel', function($m) use ($q) {
                      $m->where('nama_mapel', 'like', "%$q%") ;
                  });
        }
        $gurus = $query->get();
        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        $mapels = Mapel::all();
        return view('guru.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:gurus,email',
            'mapel_id' => 'required|exists:mapels,id',
        ]);
        $guru = Guru::create($request->only(['nip','nama', 'email', 'mapel_id']));
        // Tambahkan user baru untuk guru
        User::create([
            'username' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => 'guru',
            'password' =>$request->nip . 'MAN', // password default nip
        ]);
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        $mapels = Mapel::all();
        return view('guru.edit', compact('guru', 'mapels'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $request->validate([
             'nip' => 'required',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:gurus,email,' . $id,
            'mapel_id' => 'required|exists:mapels,id',
        ]);
        $guru->update($request->only(['nip','nama', 'email', 'mapel_id']));
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
    }

    public function destroy($id)
    {
        Guru::destroy($id);
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
