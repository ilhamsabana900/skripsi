<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Nilai::with(['siswa.user', 'mapel', 'kelas']);
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('siswa.user', function ($u) use ($q) {
                $u->where('nama', 'like', "%$q%")
                    ->orWhere('nis', 'like', "%$q%");
            });
        }
        $nilais = $query->orderBy('tanggal', 'desc')->paginate(10);
        return view('nilai.index', compact('nilais'));
    }

    public function create()
    {
        $siswas = Siswa::with('user', 'kelas')->get();
        $mapels = Mapel::all();
        $kelas = Kelas::all();
        $gurus = Guru::all();
        return view('nilai.create', compact('siswas', 'mapels', 'kelas', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:gurus,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:harian,ujian',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);
        Nilai::create($request->only(['siswa_id', 'mapel_id', 'kelas_id', 'guru_id', 'tanggal', 'jenis', 'nilai']));
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function rekap(Request $request)
    {
        $kelas = \App\Models\Kelas::all();
        $mapels = \App\Models\Mapel::all();
        $siswas = collect();
        $mapel_nama = null;
        if ($request->filled('kelas_id') && $request->filled('mapel_id')) {
            $siswas = \App\Models\Siswa::with(['user', 'kelas'])
                ->where('kelas_id', $request->kelas_id)
                ->get();
            $mapel = \App\Models\Mapel::find($request->mapel_id);
            $mapel_nama = $mapel ? $mapel->nama_mapel : null;
            foreach ($siswas as $siswa) {
                $harianList = \App\Models\Nilai::where('siswa_id', $siswa->id)
                    ->where('mapel_id', $request->mapel_id)
                    ->where('jenis', 'harian')
                    ->pluck('nilai');
                $ujianList = \App\Models\Nilai::where('siswa_id', $siswa->id)
                    ->where('mapel_id', $request->mapel_id)
                    ->where('jenis', 'ujian')
                    ->pluck('nilai');

                $avgHarian = $harianList->count() > 0 ? $harianList->sum() / $harianList->count() : 0;
                $avgUjian = $ujianList->count() > 0 ? $ujianList->sum() / $ujianList->count() : 0;

                $nilaiAkhir = round(($avgHarian * 0.7) + ($avgUjian * 0.3), 2);

                $siswa->setAttribute('nilai_harian', $avgHarian);
                $siswa->setAttribute('nilai_ujian', $avgUjian);
                $siswa->setAttribute('nilai_akhir', $nilaiAkhir);
            }
        }
        return view('nilai.rekap', compact('kelas', 'mapels', 'siswas', 'mapel_nama'));
    }

    /**
     * Simpan nilai massal untuk semua siswa dalam satu kelas.
     */
    public function storeMassal(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:gurus,id',
            'jenis' => 'required|in:harian,ujian',
            'tanggal' => 'required|date',
            'siswa_id' => 'required|array',
            'nilai' => 'required|array',
            'siswa_id.*' => 'required|exists:siswa,id',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        $data = [];
        foreach ($request->siswa_id as $i => $siswa_id) {
            $data[] = [
                'siswa_id' => $siswa_id,
                'mapel_id' => $request->mapel_id,
                'kelas_id' => $request->kelas_id,
                'guru_id' => $request->guru_id,
                'jenis' => $request->jenis,
                'tanggal' => $request->tanggal,
                'nilai' => $request->nilai[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // Hapus nilai lama untuk kombinasi siswa/mapel/jenis/tanggal yang sama (opsional, agar tidak dobel)
        foreach ($data as $row) {
            \App\Models\Nilai::where([
                ['siswa_id', $row['siswa_id']],
                ['mapel_id', $row['mapel_id']],
                ['jenis', $row['jenis']],
                ['tanggal', $row['tanggal']],
            ])->delete();
        }
        \App\Models\Nilai::insert($data);
        return redirect()->route('nilai.index')->with('success', 'Nilai massal berhasil disimpan.');
    }

    /**
     * Tampilkan form input nilai massal per kelas.
     */
    public function massal(Request $request)
    {
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $gurus = Guru::all();
        $siswas = collect();
        if ($request->filled(['kelas_id', 'mapel_id', 'jenis', 'tanggal'])) {
            $siswas = Siswa::with('user')->where('kelas_id', $request->kelas_id)->get();
        }
        return view('nilai.massal', compact('kelas', 'mapels', 'gurus', 'siswas'));
    }

    /**
     * Dummy show method untuk menghindari error resource route.
     */
    public function show($id)
    {
        // Tidak digunakan, hanya agar resource route tidak error
        return redirect()->route('nilai.index');
    }

    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $siswas = Siswa::with('user', 'kelas')->get();
        $mapels = Mapel::all();
        $kelas = Kelas::all();
        $gurus = Guru::all();
        return view('nilai.edit', compact('nilai', 'siswas', 'mapels', 'kelas', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:gurus,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:harian,ujian',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);
        $nilai = Nilai::findOrFail($id);
        $nilai->update($request->only(['siswa_id', 'mapel_id', 'kelas_id', 'guru_id', 'tanggal', 'jenis', 'nilai']));
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diupdate.');
    }

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }
    // ...existing code...
}
