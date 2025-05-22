@extends('layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-body">
                    <h3 class="mb-3">Tambah Nilai</h3>
                    <form action="{{ route('nilai.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="siswa_id" class="form-label">Siswa</label>
                            <select class="form-control" id="siswa_id" name="siswa_id" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->user->nama }} ({{ $siswa->nis }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select class="form-control" id="kelas_id" name="kelas_id" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mapel_id" class="form-label">Mapel</label>
                            <select class="form-control" id="mapel_id" name="mapel_id" required>
                                <option value="">-- Pilih Mapel --</option>
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Penilaian</label>
                            <select class="form-control" id="jenis" name="jenis" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="harian">Harian</option>
                                <option value="ujian">Ujian</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nilai" class="form-label">Nilai</label>
                            <input type="number" class="form-control" id="nilai" name="nilai" min="0" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="guru_id" class="form-label">Guru</label>
                            <select class="form-control" id="guru_id" name="guru_id" required>
                                <option value="">-- Pilih Guru --</option>
                                @foreach($gurus as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }} ({{ $g->mapel->nama_mapel ?? '-' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
