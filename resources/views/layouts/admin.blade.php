<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Perpustakaan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @stack('styles')

    <style>
        body { background-color: #f8f9fa; }
        .sidebar { 
            height: 100vh; 
            width: 250px; 
            position: fixed; 
            background: #212529; 
            color: white; 
            padding-top: 20px; 
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .main-content { margin-left: 250px; padding: 30px; }
        .nav-link { 
            color: #adb5bd; 
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .nav-link:hover, .nav-link.active { 
            color: white; 
            background: #343a40; 
        }
        .nav-link.active {
            background: #0d6efd;
            color: white !important;
        }
        hr { border-color: rgba(255,255,255,0.1); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center fw-bold">Admin Perpus</h4>
        <p class="text-center text-muted small">Panel Kendali</p>
        <hr>
        <nav class="nav flex-column px-3">
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->is('admin/buku*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                <i class="bi bi-book me-2"></i> Kelola Buku
            </a>
            <a class="nav-link {{ request()->is('admin/anggota*') ? 'active' : '' }}" href="{{ url('/admin/anggota') }}">
                <i class="bi bi-people me-2"></i> Kelola Anggota
            </a>
            <a class="nav-link {{ request()->is('admin/transaksi*') ? 'active' : '' }}" href="{{ url('/admin/transaksi') }}">
                <i class="bi bi-cart-check me-2"></i> Data Transaksi
            </a>
            <hr>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-danger btn-sm w-100 mt-2">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>