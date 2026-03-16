@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h3>Data Koleksi Buku</h3>
    <div class="d-flex gap-2">
        <select id="admin-filter-genre" class="form-select" style="width: 200px;">
            <option value="">Semua Genre</option>
            <option value="Fiksi">Fiksi</option>
            <option value="Non-Fiksi">Non-Fiksi</option>
            <option value="Novel">Novel</option>
            <option value="Edukasi">Edukasi</option>
            <option value="Teknologi">Teknologi</option>
        </select>

        <div class="input-group">
            <input type="text" id="admin-live-search" class="form-control" placeholder="Cari buku...">
        </div>
        
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah</button>
    </div>
</div>

<table class="table table-striped table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Genre</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="tabel-buku">
        @include('admin.buku._table_buku')
    </tbody>
</table>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('admin-live-search');
        const genreSelect = document.getElementById('admin-filter-genre');
        const tableBody = document.getElementById('tabel-buku');

        function fetchAdminData() {
            let keyword = searchInput.value;
            let genre = genreSelect.value;

            let url = `{{ route('buku.index') }}?search=${encodeURIComponent(keyword)}&genre=${encodeURIComponent(genre)}`;

            fetch(url, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(response => response.text())
            .then(html => {
                tableBody.innerHTML = html;
            })
            .catch(err => console.error("Error Admin Filter:", err));
        }

        searchInput.addEventListener('input', fetchAdminData);
        genreSelect.addEventListener('change', fetchAdminData);
    });
</script>
@endpush

@include('admin.buku._modal_tambah') 
@endsection