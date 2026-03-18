@extends('layouts.siswa')

@section('content')
<div class="row mb-4 align-items-end">
    <div class="col-md-4">
        <h2 class="fw-bold text-dark">Katalog Buku</h2>
        <p class="text-muted small mb-0">Temukan buku favoritmu di sini.</p>
    </div>
    <div class="col-md-8">
        <div class="row g-2">
            <div class="col-md-5">
                <label class="small fw-bold text-muted mb-1">Filter Genre:</label>

                <!-- FIX: hapus display:none -->
                <select id="filter-genre"
                        class="form-select select2"
                        name="genres[]"
                        multiple="multiple"
                        data-placeholder="Pilih Genre..."
                        style="width: 100%;">
                        
                    <option value="Fiksi">Fiksi</option>
                    <option value="Non-Fiksi">Non-Fiksi</option>
                    <option value="Novel">Novel</option>
                    <option value="Edukasi">Edukasi</option>
                    <option value="Teknologi">Teknologi</option>
                </select>
            </div>

            <div class="col-md-7">
                <label class="small fw-bold text-muted mb-1">Cari Buku:</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text"
                           id="live-search"
                           class="form-control border-start-0 shadow-none"
                           placeholder="Ketik judul atau penulis...">
                </div>
            </div>
        </div>
    </div>
</div>

<hr class="mb-4 opacity-10">

<div class="row" id="container-buku">
    @include('siswa._buku_list')
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
.select2-container {
    width: 100% !important;
}

/* Box */
.select2-container--default .select2-selection--multiple {
    border: 1px solid #dee2e6 !important;
    border-radius: 0.375rem !important;
    min-height: 38px !important;
    padding: 1px 5px !important;
    background-color: #fff !important;
}

/* Focus */
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #86b7fe !important;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25) !important;
}

/* Badge */
.select2-container--default .select2-selection__choice {
    background-color: #0d6efd !important;
    color: #fff !important;
    border: none !important;
    border-radius: 4px !important;
    padding: 1px 10px !important;
    margin-top: 6px !important;
    font-size: 0.85rem !important;
}

/* Remove button */
.select2-container--default .select2-selection__choice__remove {
    color: #fff !important;
    margin-right: 5px !important;
}

.select2-container--default .select2-selection__choice__remove:hover {
    color: #ffcccc !important;
}

/* Input search */
.select2-search__field {
    margin-top: 7px !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {

    // FIX: hapus .show()
    $('#filter-genre').select2({
        placeholder: "Pilih Genre...",
        allowClear: true
    });

    const searchInput = document.getElementById('live-search');
    const container = document.getElementById('container-buku');

    function doFilter() {
        let keyword = searchInput.value;
        let genres = $('#filter-genre').val(); 

        let params = new URLSearchParams();

        if (keyword) params.append('search', keyword);

        if (genres && genres.length > 0) {
            genres.forEach(g => params.append('genres[]', g));
        }

        fetch(`{{ route('siswa.dashboard') }}?${params.toString()}`, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(res => res.text())
        .then(html => {
            container.innerHTML = html;
        })
        .catch(err => console.error("Filter Error:", err));
    }

    searchInput.addEventListener('input', doFilter);

    $('#filter-genre').on('change', function() {
        doFilter();
    });
});
</script>
@endpush