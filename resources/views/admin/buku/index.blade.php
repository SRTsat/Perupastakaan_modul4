@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Data Koleksi Buku</h3>
    <div class="d-flex">
        <form action="{{ route('buku.index') }}" method="GET" class="me-2">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari buku/genre..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Buku Baru</button>
    </div>
</div>

<table class="table table-striped table-bordered align-middle">
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Genre</th> <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bukus as $b)
        <tr>
            <td>
                @if($b->foto)
                    <img src="{{ asset('storage/buku/'.$b->foto) }}" width="50" class="img-thumbnail">
                @else
                    <span class="text-muted">No Image</span>
                @endif
            </td>
            <td>{{ $b->judul }}</td>
            <td>{{ $b->penulis }}</td>
            <td><span class="badge bg-info text-dark">{{ $b->genre ?? 'Umum' }}</span></td> <td>{{ $b->stok }}</td>
            <td>
                <form action="{{ route('buku.destroy', $b->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus bro?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('buku.store') }}" method="POST" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5>Tambah Buku Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" class="form-control mb-2" required>
                
                <label class="form-label">Penulis</label>
                <input type="text" name="penulis" class="form-control mb-2" required>
                
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" class="form-control mb-2" required>

                <label class="form-label">Genre</label>
                <select name="genre" class="form-control mb-2" required>
                    <option value="">-- Pilih Genre --</option>
                    <option value="Fiksi">Fiksi</option>
                    <option value="Non-Fiksi">Non-Fiksi</option>
                    <option value="Novel">Novel</option>
                    <option value="Edukasi">Edukasi</option>
                    <option value="Teknologi">Teknologi</option>
                </select>
                
                <label class="form-label">Jumlah Stok</label>
                <input type="number" name="stok" class="form-control mb-2" required>
                
                <label class="form-label">Upload Foto Cover</label>
                <input type="file" name="foto" class="form-control mb-2" accept="image/*">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>
@endsection