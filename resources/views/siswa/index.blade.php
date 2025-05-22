@extends('layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">

                <div class="card-body">
                    <h3 class="mb-3">Data Siswa</h3>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-8 col-12">
                            <form method="GET" action="{{ route('siswa.index') }}" class="form-inline">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" name="q" class="form-control" placeholder="Cari Data Siswa" value="{{ request('q') }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">
                            <a href="{{ route('siswa.create') }}" class="btn btn-success">+ Tambah Siswa</a>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>User</th>
                                <th>Kelas</th>
                                <th>NIS</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswas as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->user->nama ?? '-' }}</td>
                                <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $siswa->nis ?? '-' }}</td>
                                <td>{{ $siswa->no_hp ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>
@endsection
