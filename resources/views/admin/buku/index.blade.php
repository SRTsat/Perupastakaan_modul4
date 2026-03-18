@extends('layouts.admin')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-4 align-items-end">
            <div>
                <h3 class="fw-bold mb-0">Kelola Koleksi Buku</h3>
                <p class="text-muted small mb-0">Manajemen data buku, filter, dan laporan PDF.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('buku.exportPdf') }}" class="btn btn-danger shadow-sm">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
                <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg"></i> Tambah Buku
                </button>
            </div>
        </div>

        <div class="row g-3 mb-4 bg-light p-3 rounded shadow-sm">
            <div class="col-md-6">
                <label class="small fw-bold text-muted mb-1">Filter Berdasarkan Genre:</label>
                <select id="admin-filter-genre" class="form-select select2" name="genres[]" multiple="multiple" data-placeholder="Semua Genre..." style="display: none; width: 100%;">
                    <option value="Fiksi">Fiksi</option>
                    <option value="Non-Fiksi">Non-Fiksi</option>
                    <option value="Novel">Novel</option>
                    <option value="Edukasi">Edukasi</option>
                    <option value="Teknologi">Teknologi</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="small fw-bold text-muted mb-1">Pencarian Cepat:</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="admin-live-search" class="form-control border-start-0 shadow-none" placeholder="Cari judul, penulis, atau penerbit...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="80">Cover</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Genre</th>
                        <th>Stok</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-buku">
                    @include('admin.buku._table_buku')
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.buku._modal_tambah')
@include('admin.buku._modal_edit')

@endsection

@push('styles')
{{-- Select2 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Styling agar Select2 sinkron dengan Bootstrap 5 */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #dee2e6 !important;
        border-radius: 0.375rem !important;
        min-height: 38px !important;
        padding: 2px 5px !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #86b7fe !important;
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25) !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #0d6efd !important;
        color: white !important;
        border: none !important;
        padding: 1px 10px !important;
        margin-top: 5px !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white !important;
        margin-right: 5px !important;
    }
</style>
@endpush

@push('scripts')
{{-- Load jQuery dan Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // 1. Inisialisasi Select2
        $('#admin-filter-genre').select2({
            placeholder: "Filter Genre..",
            allowClear: true
        }).show(); // Langsung tampilkan setelah di-init

        const searchInput = document.getElementById('admin-live-search');
        const tableBody = document.getElementById('tabel-buku');

        // 2. Fungsi Fetch Data (Live Search & Multi-Filter)
        function fetchAdminData() {
            let keyword = searchInput.value;
            let genres = $('#admin-filter-genre').val();

            let params = new URLSearchParams();
            if(keyword) params.append('search', keyword);
            if(genres && genres.length > 0) {
                genres.forEach(g => params.append('genres[]', g));
            }

            fetch(`{{ route('buku.index') }}?${params.toString()}`, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(res => res.text())
            .then(html => {
                tableBody.innerHTML = html;
            })
            .catch(err => console.error("Filter Error:", err));
        }

        // Event Listeners
        searchInput.addEventListener('input', fetchAdminData);
        $('#admin-filter-genre').on('change', function() {
            fetchAdminData();
        });

        // 3. Logika Isi Modal Edit (Passing Data)
        const modalEdit = document.getElementById('modalEdit');
        if (modalEdit) {
            modalEdit.addEventListener('show.bs.modal', function (event) {
                const btn = event.relatedTarget;
                const form = document.getElementById('formEdit');
                
                // Set Action Form Update
                form.action = `/admin/buku/${btn.getAttribute('data-id')}`;
                
                // Isi field modal
                document.getElementById('edit-judul').value = btn.getAttribute('data-judul');
                document.getElementById('edit-penulis').value = btn.getAttribute('data-penulis');
                document.getElementById('edit-penerbit').value = btn.getAttribute('data-penerbit');
                document.getElementById('edit-genre').value = btn.getAttribute('data-genre');
                document.getElementById('edit-stok').value = btn.getAttribute('data-stok');
            });
        }
    });
</script>
@endpush