<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;

class CrudController extends Controller
{
    // CRUD untuk Admin
    public function indexAdmin()
    {
        return Admin::all();
    }
    public function showAdmin($id)
    {
        return Admin::findOrFail($id);
    }
    public function storeAdmin(Request $request)
    {
        return Admin::create($request->all());
    }
    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update($request->all());
        return $admin;
    }
    public function destroyAdmin($id)
    {
        Admin::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // CRUD untuk Guru
    public function indexGuru()
    {
        return Guru::all();
    }
    public function showGuru($id)
    {
        return Guru::findOrFail($id);
    }
    public function storeGuru(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|unique:gurus,nip',
            'nama' => 'required|string|max:255',
            'mapel_id' => 'required|exists:mapels,id',
        ]);
        $guru = Guru::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'mapel_id' => $request->mapel_id,
        ]);
        // Buat user login untuk guru
        \App\Models\User::create([
            'username' => $request->nip,
            'password' => $request->nip . 'MAN', // plain text sesuai permintaan
            'role' => 'guru',
            'guru_id' => $guru->id,
        ]);
        return $guru;
    }
    public function updateGuru(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $request->validate([
            'nip' => 'required|string|unique:gurus,nip,' . $id,
            'nama' => 'required|string|max:255',
            'mapel_id' => 'required|exists:mapels,id',
        ]);
        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'mapel_id' => $request->mapel_id,
        ]);
        // Update user login jika ada
        $user = \App\Models\User::where('guru_id', $guru->id)->first();
        if ($user) {
            $user->update([
                'username' => $request->nip,
                'password' => $request->nip . 'MAN', // plain text
            ]);
        }
        return $guru;
    }
    public function destroyGuru($id)
    {
        Guru::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // CRUD untuk Kelas
    public function indexKelas()
    {
        return Kelas::all();
    }
    public function showKelas($id)
    {
        return Kelas::findOrFail($id);
    }
    public function storeKelas(Request $request)
    {
        return Kelas::create($request->all());
    }
    public function updateKelas(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());
        return $kelas;
    }
    public function destroyKelas($id)
    {
        Kelas::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // CRUD untuk Mapel
    public function indexMapel()
    {
        return Mapel::all();
    }
    public function showMapel($id)
    {
        return Mapel::findOrFail($id);
    }
    public function storeMapel(Request $request)
    {
        return Mapel::create($request->all());
    }
    public function updateMapel(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->update($request->all());
        return $mapel;
    }
    public function destroyMapel($id)
    {
        Mapel::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // CRUD untuk Nilai
    public function indexNilai()
    {
        return Nilai::all();
    }
    public function showNilai($id)
    {
        return Nilai::findOrFail($id);
    }
    public function storeNilai(Request $request)
    {
        return Nilai::create($request->all());
    }
    public function updateNilai(Request $request, $id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->update($request->all());
        return $nilai;
    }
    public function destroyNilai($id)
    {
        Nilai::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // CRUD untuk Siswa
    public function indexSiswa()
    {
        return Siswa::all();
    }
    public function showSiswa($id)
    {
        return Siswa::findOrFail($id);
    }
    public function storeSiswa(Request $request)
    {
        return Siswa::create($request->all());
    }
    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());
        return $siswa;
    }
    public function destroySiswa($id)
    {
        Siswa::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // CRUD untuk User
    public function indexUser()
    {
        return User::all();
    }
    public function showUser($id)
    {
        return User::findOrFail($id);
    }
    public function storeUser(Request $request)
    {
        return User::create($request->all());
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return $user;
    }
    public function destroyUser($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // Dashboard
    public function dashboard()
    {
        $jumlahSiswa = \App\Models\Siswa::count();
        $jumlahGuru = \App\Models\Guru::count();
        $jumlahKelas = \App\Models\Kelas::count();
        return view('dashboard', compact('jumlahSiswa', 'jumlahGuru', 'jumlahKelas'));
    }

    // CRUD untuk Mapel (web views)
    public function createMapel() {
        return view('mapel.create');
    }
    public function editMapel($id) {
        $mapel = Mapel::findOrFail($id);
        return view('mapel.edit', compact('mapel'));
    }
    public function indexMapelWeb() {
        $mapels = Mapel::paginate(10);
        return view('mapel.index', compact('mapels'));
    }
    public function storeMapelWeb(Request $request) {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
        ]);
        Mapel::create($request->only(['nama_mapel']));
        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil ditambahkan.');
    }
    public function updateMapelWeb(Request $request, $id) {
        $mapel = Mapel::findOrFail($id);
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
        ]);
        $mapel->update($request->only(['nama_mapel']));
        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil diupdate.');
    }
    public function destroyMapelWeb($id) {
        Mapel::destroy($id);
        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil dihapus.');
    }
}
