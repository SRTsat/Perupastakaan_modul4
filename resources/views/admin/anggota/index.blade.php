@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h3>Data Anggota (Siswa)</h3>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Anggota</button>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Tanggal Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anggotas as $index => $a)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $a->name }}</td>
                    <td>{{ $a->username }}</td>
                    <td>{{ $a->created_at->format('d M Y') }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $a->id }}">Edit</button>
                        <form action="{{ route('admin.anggota.destroy', $a->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus anggota ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                <div class="modal fade" id="modalEdit{{ $a->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.anggota.update', $a->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header"><h5>Edit Anggota</h5></div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ $a->name }}" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Username</label>
                                        <input type="text" name="username" value="{{ $a->username }}" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Password (Kosongkan jika tidak ganti)</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.anggota.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5>Tambah Anggota Baru</h5></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection