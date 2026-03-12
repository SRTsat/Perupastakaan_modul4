@extends('layouts.siswa')

@section('content')
<div class="row">
    @foreach($bukus as $b)
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
            @if($b->foto)
                <img src="{{ asset('storage/buku/'.$b->foto) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
            @else
                <div class="bg-secondary text-white text-center py-5">No Image</div>
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $b->judul }}</h5>
                <p class="card-text text-muted small">Penulis: {{ $b->penulis }}<br>Stok: {{ $b->stok }}</p>
                
                @if($b->stok > 0)
                    <form action="{{ route('pinjam.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $b->id }}">
                        <button type="submit" class="btn btn-primary btn-sm w-100">Pinjam Buku</button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-sm w-100" disabled>Stok Habis</button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection