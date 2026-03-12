@extends('layouts.siswa')

@section('content')
<h3>Buku yang Saya Pinjam</h3>
<table class="table table-bordered mt-3">
    <thead class="table-light">
        <tr>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pinjaman as $p)
        <tr>
            <td>{{ $p->buku->judul }}</td>
            <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
            <td>
                <span class="badge bg-{{ $p->status == 'dipinjam' ? 'warning' : 'success' }}">
                    {{ ucfirst($p->status) }}
                </span>
            </td>
            <td>
                @if($p->status == 'dipinjam')
                    <form action="{{ route('pinjam.kembali', $p->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-success">Kembalikan</button>
                    </form>
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection