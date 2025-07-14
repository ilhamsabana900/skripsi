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
                                        <input type="text" name="q" class="form-control" placeholder="Cari Nama, Kelas, NIS, atau No HP" value="{{ request('q') }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0 d-flex justify-content-md-end gap-2">
                            <a href="{{ route('siswa.create') }}" class="btn btn-success">+ Tambah Siswa</a>
                            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
                                @csrf
                                <label class="btn btn-outline-primary mb-0">
                                    Import Excel <input type="file" name="file" class="d-none" accept=".xlsx,.xls,.csv" onchange="this.form.submit()">
                                </label>
                            </form>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="{{ url('siswa/download-template') }}" class="btn btn-outline-info">
                            <i class="fa fa-download"></i> Download Template Import Siswa (Excel)
                        </a>
                    </div>
                    <form id="form-multi-delete" action="{{ route('siswa.multiDelete') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <button type="button" class="btn btn-danger btn-sm" id="btn-delete-selected">Hapus Terpilih</button>
                            <button type="button" class="btn btn-secondary btn-sm" id="btn-select-all">Pilih Semua</button>
                            <button type="button" class="btn btn-secondary btn-sm" id="btn-unselect-all">Batal Pilih Semua</button>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="check-all"></th>
                                    <th>No.</th>
                                    <th>User</th>
                                    <th>Kelas</th>
                                    <th>NIS</th>
                                    <th>No HP</th>
                                    <th>Username</th>
                                    <th>Password Default</th>
                                    <!-- <th>Nilai Akumulasi</th> -->
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $siswa)
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="{{ $siswa->id }}" class="check-item"></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $siswa->user->nama ?? '-' }}</td>
                                    <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $siswa->nis ?? '-' }}</td>
                                    <td>{{ $siswa->no_hp ?? '-' }}</td>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>{{ $siswa->nis }}MAN</td>
                                    <!-- <td>
                                        {{-- Nilai Akumulasi --}}
                                        {{ method_exists($siswa, 'nilaiAkumulasi') ? number_format($siswa->nilaiAkumulasi(), 2) : '-' }}
                                    </td> -->
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
                    </form>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        // Pilih semua checkbox
                        document.getElementById('check-all')?.addEventListener('click', function() {
                            let checked = this.checked;
                            document.querySelectorAll('.check-item').forEach(cb => cb.checked = checked);
                        });
                        document.getElementById('btn-select-all')?.addEventListener('click', function() {
                            document.querySelectorAll('.check-item').forEach(cb => cb.checked = true);
                            document.getElementById('check-all').checked = true;
                        });
                        document.getElementById('btn-unselect-all')?.addEventListener('click', function() {
                            document.querySelectorAll('.check-item').forEach(cb => cb.checked = false);
                            document.getElementById('check-all').checked = false;
                        });
                        // AJAX multi delete
                        $(document).on('click', '#btn-delete-selected', function(e) {
                            e.preventDefault();
                            let ids = [];
                            $('.check-item:checked').each(function() {
                                ids.push($(this).val());
                            });
                            if(ids.length === 0) {
                                alert('Pilih minimal satu data yang akan dihapus!');
                                return;
                            }
                            if(!confirm('Yakin hapus data terpilih?')) return;
                            $.ajax({
                                url: $('#form-multi-delete').attr('action'),
                                type: 'POST',
                                data: {
                                    _token: $('input[name="_token"]').val(),
                                    ids: ids
                                },
                                success: function(res) {
                                    // reload page or remove rows
                                    location.reload();
                                },
                                error: function(xhr) {
                                    alert('Gagal menghapus data!');
                                }
                            });
                        });
                    </script>
                    <div class="d-flex justify-content-center">
                        {!! $siswas->onEachSide(1)->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
