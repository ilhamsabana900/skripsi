@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h3 class="mb-4">Edit Mata Pelajaran</h3>
    <form action="{{ route('mapel.update', $mapel->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_mapel" class="form-label">Nama Mapel</label>
            <input type="text" name="nama_mapel" id="nama_mapel" class="form-control" required value="{{ old('nama_mapel', $mapel->nama_mapel) }}">
        </div>
        <div class="mb-3">
            <label for="kode_mapel" class="form-label">Kode Mapel</label>
            <input type="text" name="kode_mapel" id="kode_mapel" class="form-control" required value="{{ old('kode_mapel', $mapel->kode_mapel) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('mapel.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
