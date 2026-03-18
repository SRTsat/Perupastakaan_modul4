@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Dashboard Admin</h3>
    
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="opacity-75">Total Koleksi Buku</small>
                        <h2 class="fw-bold mb-0">{{ $total_buku }}</h2>
                    </div>
                    <i class="bi bi-book fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="opacity-75">Total Siswa/Anggota</small>
                        <h2 class="fw-bold mb-0">{{ $total_siswa }}</h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-dark p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="fw-bold opacity-75">Buku Belum Kembali</small>
                        <h2 class="fw-bold mb-0">{{ $total_pinjam }}</h2>
                    </div>
                    <i class="bi bi-clock-history fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-danger text-white p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="opacity-75">Total Kas Denda</small>
                        <h2 class="fw-bold mb-0">Rp {{ number_format($total_denda, 0, ',', '.') }}</h2>
                    </div>
                    <i class="bi bi-cash-coin fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4 border-0 shadow-sm">
        <div class="card-body p-4 text-center">
            <h4>Selamat Datang, <strong>{{ Auth::user()->name }}</strong>!</h4>
            <p class="text-muted">Aplikasi Perpustakaan Digital siap dikelola hari ini.</p>
        </div>
    </div>
</div>
@endsection