@extends('layouts.admin')

@section('content')
<div class="mb-3">
    <h3>Riwayat Transaksi Peminjaman</h3>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $t)
                <tr>
                    <td>{{ $t->user->name }}</td>
                    <td>{{ $t->buku->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td>{{ $t->tanggal_kembali ? \Carbon\Carbon::parse($t->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                    <td>
                        @if($t->status == 'dipinjam')
                            <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                        @else
                            <span class="badge bg-success">Sudah Dikembalikan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection