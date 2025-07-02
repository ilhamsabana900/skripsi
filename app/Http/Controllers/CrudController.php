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
use Illuminate\Support\Facades\Hash;

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
        // Buat user dulu
        $user = User::create([
            'username' => $request->nip,
            'password' => bcrypt($request->nip . 'MAN'),
            'role' => 'guru',
            'nama' => $request->nama,
            'email' => $request->email,
        ]);
        // Buat guru dan hubungkan ke user
        $guru = Guru::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'mapel_id' => $request->mapel_id,
            'user_id' => $user->id,
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
    public function indexNilai(Request $request)
    {
        $query = \App\Models\Nilai::with(['siswa.user', 'mapel', 'kelas']);
        if ($request->has('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->has('mapel_id')) {
            $query->where('mapel_id', $request->mapel_id);
        }
        if ($request->filled('nis')) {
            $nis = $request->nis;
            $query->whereHas('siswa.user', function($u) use ($nis) {
                $u->where('nis', $nis);
            });
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('siswa.user', function($u) use ($q) {
                $u->where('nama', 'like', "%$q%")
                  ->orWhere('nis', 'like', "%$q%") ;
            });
        }
        // Urutkan berdasarkan tanggal terbaru
        return $query->orderBy('tanggal', 'desc')->get();
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
    public function indexSiswa(Request $request)
    {
        if ($request->has('kelas_id')) {
            $kelasId = $request->query('kelas_id');
            return Siswa::where('kelas_id', $kelasId)->with('user')->get();
        }
        return Siswa::with('user')->get();
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

    // Endpoint untuk mendapatkan nilai akumulasi siswa
    public function nilaiAkumulasi($siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);
        $nilaiAkumulasi = $siswa->nilaiAkumulasi();

        return response()->json([
            'siswa_id' => $siswa->id,
            'nilai_akumulasi' => $nilaiAkumulasi,
        ]);
    }

    // Endpoint untuk menghitung nilai akumulasi per mapel berdasarkan jenis nilai (harian dan ujian) dengan bobot 70% dan 30%
    public function nilaiAkumulasiPerMapel($siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);

        // Ambil rata-rata nilai per mapel dan jenis (harian/ujian)
        $nilaiPerMapel = $siswa->nilai()
            ->selectRaw('mapel_id, jenis, SUM(nilai) as total_nilai, COUNT(nilai) as jumlah_penilaian')
            ->groupBy('mapel_id', 'jenis')
            ->get();

        $akumulasiPerMapel = [];

        // Kelompokkan per mapel
        foreach ($nilaiPerMapel->groupBy('mapel_id') as $mapelId => $nilaiGroup) {
            $nilaiHarian = $nilaiGroup->where('jenis', 'harian')->first();
            $nilaiUjian = $nilaiGroup->where('jenis', 'ujian')->first();

            // Jika tidak ada nilai harian/ujian, anggap 0
            $rataRataHarian = $nilaiHarian && $nilaiHarian->jumlah_penilaian > 0
                ? $nilaiHarian->total_nilai / $nilaiHarian->jumlah_penilaian
                : 0;
            $rataRataUjian = $nilaiUjian && $nilaiUjian->jumlah_penilaian > 0
                ? $nilaiUjian->total_nilai / $nilaiUjian->jumlah_penilaian
                : 0;

            // Hitung nilai akhir dengan bobot 70% harian, 30% ujian
            $nilaiAkhir = ($rataRataHarian * 0.7) + ($rataRataUjian * 0.3);

            // Masukkan ke array hasil
            $akumulasiPerMapel[] = [
                'mapel_id' => $mapelId,
                'rata_rata_harian' => round($rataRataHarian, 2),
                'rata_rata_ujian' => round($rataRataUjian, 2),
                'nilai_akumulasi' => round($nilaiAkhir, 2),
            ];
        }

        return response()->json($akumulasiPerMapel);
    }

    // Ubah Password Guru (API)
    public function changePasswordGuru(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $nip = $guru->nip;
        $user = User::where('username', $nip)->where('role', 'guru')->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User guru tidak ditemukan!'], 404);
        }
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
        ]);
        // Cek password lama
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama salah!'], 400);
        }
        $user->password = bcrypt($request->new_password);
        $user->save();
        return response()->json(['success' => true, 'message' => 'Password berhasil diubah!']);
    }
}
