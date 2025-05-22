@extends('layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-body">
                    <h3 class="mb-3">Data Nilai</h3>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-8 col-12">
                            <form method="GET" action="{{ route('nilai.index') }}" class="form-inline">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" name="q" class="form-control" placeholder="Cari Nama Siswa/NIS" value="{{ request('q') }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                        <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">
                            <a href="{{ route('nilai.create') }}" class="btn btn-success">+ Tambah Nilai</a>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Mapel</th>
                                <th>Jenis</th>
                                <th>Nilai</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilais as $nilai)
                            <tr>
                                <td>{{ ($nilais->currentPage() - 1) * $nilais->perPage() + $loop->iteration }}</td>
                                <td>{{ $nilai->siswa->user->nama ?? '-' }}</td>
                                <td>{{ $nilai->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
                                <td>{{ ucfirst($nilai->jenis) }}</td>
                                <td>{{ $nilai->nilai }}</td>
                                <td>{{ $nilai->tanggal }}</td>
                                <td>
                                    <a href="{{ route('nilai.edit', $nilai->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('nilai.destroy', $nilai->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $nilais->onEachSide(1)->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
