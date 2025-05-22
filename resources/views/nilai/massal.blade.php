@extends('layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-body">
                    <h3 class="mb-3">Input Nilai Massal Per Kelas</h3>
                    <form method="GET" action="">
                        <div class="row g-2 mb-3">
                            <div class="col-md-3">
                                <select name="kelas_id" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="mapel_id" class="form-control" required>
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach($mapels as $m)
                                        <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="jenis" class="form-control" required>
                                    <option value="">-- Jenis --</option>
                                    <option value="harian" {{ request('jenis')=='harian'?'selected':'' }}>Harian</option>
                                    <option value="ujian" {{ request('jenis')=='ujian'?'selected':'' }}>Ujian</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}" required>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary w-100" type="submit">Tampilkan</button>
                            </div>
                        </div>
                    </form>
                    @if($siswas && count($siswas))
                    <form action="{{ route('nilai.massal.store') }}" method="POST" onsubmit="return confirm('Yakin data nilai sudah benar?')">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ request('kelas_id') }}">
                        <input type="hidden" name="mapel_id" value="{{ request('mapel_id') }}">
                        <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                        <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                        <div class="mb-3">
                            <label for="guru_id" class="form-label">Guru</label>
                            <select class="form-control" id="guru_id" name="guru_id" required>
                                <option value="">-- Pilih Guru --</option>
                                @foreach($gurus as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }} ({{ $g->mapel->nama_mapel ?? '-' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $i => $siswa)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $siswa->user->nama ?? '-' }}</td>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>
                                        <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                                        <input type="number" name="nilai[]" class="form-control" min="0" max="100" required>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success">Simpan Semua Nilai</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
