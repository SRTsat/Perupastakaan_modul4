@extends('layouts.siswa')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h3 class="mb-0">Katalog Buku Digital</h3>
    </div>
    <div class="col-md-6 text-end">
        <div class="input-group shadow-sm">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" id="live-search" class="form-control border-start-0" placeholder="Ketik judul, penulis, atau genre..." autocomplete="off">
        </div>
    </div>
</div>

<div class="row" id="container-buku">
    @include('siswa._buku_list')
</div>

<script>
    document.getElementById('live-search').addEventListener('input', function() {
        let keyword = this.value;

        // Mengirim request fetch ke SiswaController
        fetch("{{ route('siswa.dashboard') }}?search=" + keyword, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(response => response.text())
        .then(html => {
            // Update isi container-buku dengan hasil render dari server
            document.getElementById('container-buku').innerHTML = html;
        })
        .catch(error => console.warn('Error:', error));
    });
</script>
@endsection