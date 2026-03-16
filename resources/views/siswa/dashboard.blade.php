@extends('layouts.siswa')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <h3 class="mb-0">Katalog Buku</h3>
    </div>
    <div class="col-md-8">
        <div class="row g-2">
            <div class="col-md-4">
                <select id="filter-genre" class="form-select shadow-sm">
                    <option value="">Semua Genre</option>
                    <option value="Fiksi">Fiksi</option>
                    <option value="Non-Fiksi">Non-Fiksi</option>
                    <option value="Novel">Novel</option>
                    <option value="Edukasi">Edukasi</option>
                    <option value="Teknologi">Teknologi</option>
                </select>
            </div>
            <div class="col-md-8">
                <div class="input-group shadow-sm">
                    <input type="text" id="live-search" class="form-control" placeholder="Cari judul atau penulis...">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="container-buku">
    @include('siswa._buku_list')
</div>

@push('scripts')
<script>
    // Bungkus semua kode dalam listener ini bro
    document.addEventListener('DOMContentLoaded', function() {
        
        const searchInput = document.getElementById('live-search');
        const genreSelect = document.getElementById('filter-genre');
        const container = document.getElementById('container-buku');

        // Pastikan elemennya beneran ketemu dulu
        if (searchInput && genreSelect && container) {
            
            function doFilter() {
                let keyword = searchInput.value;
                let genre = genreSelect.value;

                console.log("Nyari:", keyword, "Genre:", genre);

                let url = `{{ route('siswa.dashboard') }}?search=${encodeURIComponent(keyword)}&genre=${encodeURIComponent(genre)}`;

                fetch(url, {
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                })
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                })
                .catch(err => console.error("Error filternya:", err));
            }

            genreSelect.addEventListener('change', doFilter);
            searchInput.addEventListener('input', doFilter);
            
        } else {
            console.error("Waduh elemen inputnya belum ketemu bro!");
        }
    });
</script>
@endpush
@endsection