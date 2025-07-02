@extends('layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-body">
                    <h3 class="mb-3">Data Guru</h3>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-8 col-12">
                            <form method="GET" action="{{ route('guru.index') }}" class="form-inline">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" name="q" class="form-control" placeholder="Cari Nama, Email, atau Mapel" value="{{ request('q') }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                        <a href="{{ route('guru.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">
                            <a href="{{ route('guru.create') }}" class="btn btn-success">+ Tambah Guru</a>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Mapel</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gurus as $guru)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $guru->nip }}</td>
                                <td>{{ $guru->nama }}</td>
                                <td>{{ $guru->email }}</td>
                                <td>{{ $guru->mapel->nama_mapel ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                    <form action="{{ url('admin/guru/'.$guru->id.'/reset-password') }}" method="POST" style="display:inline-block; margin-top:4px;">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Reset password guru ini ke default (nip+MAN)?')">Reset Password</button>
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
</div>
@endsection
