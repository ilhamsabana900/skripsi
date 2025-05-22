@extends('layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-body">
                    <h3 class="mb-3">Edit Nilai</h3>
                    <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="siswa_id" class="form-label">Siswa</label>
                                <select name="siswa_id" class="form-control" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswas as $siswa)
                                        <option value="{{ $siswa->id }}" {{ $nilai->siswa_id == $siswa->id ? 'selected' : '' }}>{{ $siswa->user->nama ?? '-' }} ({{ $siswa->nis }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="mapel_id" class="form-label">Mapel</label>
                                <select name="mapel_id" class="form-control" required>
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach($mapels as $mapel)
                                        <option value="{{ $mapel->id }}" {{ $nilai->mapel_id == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="kelas_id" class="form-label">Kelas</label>
                                <select name="kelas_id" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($kelas as $kls)
                                        <option value="{{ $kls->id }}" {{ $nilai->kelas_id == $kls->id ? 'selected' : '' }}>{{ $kls->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="guru_id" class="form-label">Guru</label>
                                <select name="guru_id" class="form-control" required>
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach($gurus as $guru)
                                        <option value="{{ $guru->id }}" {{ $nilai->guru_id == $guru->id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ $nilai->tanggal }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select name="jenis" class="form-control" required>
                                    <option value="harian" {{ $nilai->jenis=='harian'?'selected':'' }}>Harian</option>
                                    <option value="ujian" {{ $nilai->jenis=='ujian'?'selected':'' }}>Ujian</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="nilai" class="form-label">Nilai</label>
                                <input type="number" name="nilai" class="form-control" min="0" max="100" value="{{ $nilai->nilai }}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Nilai</button>
                        <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
