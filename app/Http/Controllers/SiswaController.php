<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::with(['user', 'kelas']);
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('user', function($u) use ($q) {
                $u->where('nama', 'like', "%$q%")
                  ->orWhere('username', 'like', "%$q%")
                  ->orWhere('email', 'like', "%$q%") ;
            })
            ->orWhereHas('kelas', function($k) use ($q) {
                $k->where('nama_kelas', 'like', "%$q%") ;
            })
            ->orWhere('nis', 'like', "%$q%")
            ->orWhere('no_hp', 'like', "%$q%") ;
        }
        $siswas = $query->paginate(10); // pagination 10 per halaman
        return view('siswa.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('siswa.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'nis' => 'required|string|unique:siswa,nis',
            'no_hp' => 'nullable|string|max:20',
        ]);
        // Buat user baru
        $user = \App\Models\User::create([
            'nama' => $request->nama,
            'username' => $request->nis,
            'role' => 'siswa',
            'password' => $request->nis . 'MAN', // plain text password
        ]);
        // Buat siswa baru
        Siswa::create([
            'user_id' => $user->id,
            'kelas_id' => $request->kelas_id, // pastikan ini sesuai
            'nis' => $request->nis,
            'no_hp' => $request->no_hp,
        ]);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        // Update data siswa
        $siswa->update([
            'nis' => $request->nis,
            'no_hp' => $request->no_hp,
            'kelas_id' => $request->kelas_id,
        ]);
        // Update nama user terkait
        if ($siswa->user) {
            $siswa->user->update(['nama' => $request->nama]);
        }
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Siswa::destroy($id);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    // Tambahkan method untuk import excel
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new SiswaImport, $request->file('file'));
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diimport.');
    }
}
