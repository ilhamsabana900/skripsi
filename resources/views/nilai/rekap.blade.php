@extends('layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-body">
                    <h3 class="mb-3">Rekap Nilai Siswa</h3>
                    <form method="GET" action="" class="row g-2 mb-3">
                        <div class="col-md-4">
                            <select name="kelas_id" class="form-control">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="mapel_id" class="form-control">
                                <option value="">-- Pilih Mapel --</option>
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit">Tampilkan</button>
                        </div>
                    </form>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Mapel</th>
                                <th>Nilai Harian</th>
                                <th>Nilai Ujian</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswas as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->user->nama ?? '-' }}</td>
                                <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $mapel_nama ?? '-' }}</td>
                                <td>{{ $siswa->nilai_harian ?? '-' }}</td>
                                <td>{{ $siswa->nilai_ujian ?? '-' }}</td>
                                <td>{{ $siswa->nilai_akhir ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
