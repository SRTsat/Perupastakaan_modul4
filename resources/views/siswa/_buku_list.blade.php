@forelse($bukus as $b)
<div class="col-md-3 mb-4">
    <div class="card h-100 shadow-sm border-0">
        @if($b->foto)
            <img src="{{ asset('storage/buku/'.$b->foto) }}" class="card-img-top" style="height: 250px; object-fit: cover;">
        @else
            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 250px;">No Image</div>
        @endif
        
        <div class="card-body">
            <span class="badge bg-info text-dark mb-2">{{ $b->genre ?? 'Umum' }}</span>
            <h5 class="card-title text-truncate">{{ $b->judul }}</h5>
            <p class="card-text text-muted small mb-3">
                Penulis: {{ $b->penulis }}<br>
                Stok: <strong>{{ $b->stok }}</strong>
            </p>
            
            @if($b->stok > 0)
                <form action="{{ route('pinjam.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="buku_id" value="{{ $b->id }}">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">Pinjam Buku</button>
                </form>
            @else
                <button class="btn btn-secondary w-100" disabled>Stok Habis</button>
            @endif
        </div>
    </div>
</div>
@empty
<div class="col-12 text-center py-5">
    <p class="text-muted">Buku nggak ketemu bro!</p>
</div>
@endforelse