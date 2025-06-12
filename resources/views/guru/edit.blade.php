@extends('layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-body">
                    <h3 class="mb-3">Edit Data Guru</h3>
                    <form action="{{ route('guru.update', $guru->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $guru->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $guru->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="mapel_id" class="form-label">Mapel</label>
                            <select class="form-control" id="mapel_id" name="mapel_id" required>
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}" {{ $guru->mapel_id == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" value="{{ $guru->nip }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('guru.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
