@extends('layouts.siswa')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h3 class="fw-bold mb-4">Buku yang Saya Pinjam</h3>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status / Denda</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pinjaman as $p)
                    <tr>
                        <td class="fw-bold">{{ $p->buku->judul }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>
                            <span class="text-danger fw-bold">
                                {{ \Carbon\Carbon::parse($p->deadline)->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            @if($p->status == 'dipinjam')
                                <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                            @else
                                <span class="badge bg-success">Sudah Dikembalikan</span>
                                @if($p->denda > 0)
                                    <div class="mt-1">
                                        <span class="badge bg-danger">Denda: Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if($p->status == 'dipinjam')
                                <form action="{{ route('pinjam.kembali', $p->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-success px-3 rounded-pill shadow-sm" onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                        <i class="bi bi-arrow-return-left me-1"></i> Kembalikan
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small">Selesai pada:<br>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d/m/y') }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection