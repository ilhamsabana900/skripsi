@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h3 class="mb-4">Tambah Mata Pelajaran</h3>
    <form action="{{ route('mapel.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_mapel" class="form-label">Nama Mapel</label>
            <input type="text" name="nama_mapel" id="nama_mapel" class="form-control" required value="{{ old('nama_mapel') }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('mapel.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
