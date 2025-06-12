@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data Mata Pelajaran</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="mb-3 text-end">
        <a href="{{ route('mapel.create') }}" class="btn btn-success">+ Tambah Mapel</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mapel</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mapels as $no => $mapel)
            <tr>
                <td>{{ $no + $mapels->firstItem() }}</td>
                <td>{{ $mapel->nama_mapel }}</td>
                <td>
                    <a href="{{ route('mapel.edit', $mapel->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('mapel.destroy', $mapel->id) }}" method="POST" style="display:inline-block;">
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
        {!! $mapels->onEachSide(1)->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection
