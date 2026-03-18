<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function dashboard(Request $request) {
        $search = $request->search;
        $genres = $request->genres; // Sekarang ini isinya Array [ "Fiksi", "Novel" ]

        $query = \App\Models\Buku::query();

        // Filter Multi-Genre
        if ($request->filled('genres')) {
            $query->whereIn('genre', $genres); // Pakai whereIn untuk array
        }

        // Live Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        $bukus = $query->get();

        if ($request->ajax()) {
            return view('siswa._buku_list', compact('bukus'))->render();
        }

        return view('siswa.dashboard', compact('bukus'));
    }

    // INI YANG TADI ILANG BRO: Menampilkan buku yang sedang dipinjam
    public function indexPinjam() {
        $pinjaman = Peminjaman::where('user_id', Auth::id())
                    ->with('buku')
                    ->latest()
                    ->get();
        
        return view('siswa.pinjam', compact('pinjaman'));
    }

    // Melakukan Peminjaman (Update: Tambah Deadline)
    public function pinjamBuku(Request $request) {
        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now(),
            'deadline' => now()->addDays(7), // OTOMATIS: Deadline 7 hari dari sekarang
            'status' => 'dipinjam'
        ]);

        $buku->decrement('stok');

        return redirect()->route('siswa.pinjam')->with('success', 'Buku berhasil dipinjam! Batas waktu 7 hari.');
    }

    // Melakukan Pengembalian (Update: Hitung Denda Otomatis)
    public function kembaliBuku($id) {
        $pinjam = Peminjaman::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($pinjam->status == 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan!');
        }

        $tgl_kembali = now();
        $deadline = Carbon::parse($pinjam->deadline);
        $denda = 0;

        // LOGIKA DENDA: Cek kalau hari ini ngelewatin deadline
        if ($tgl_kembali->gt($deadline)) {
            $selisih_hari = $tgl_kembali->diffInDays($deadline);
            $denda = $selisih_hari * 1000; // Misal 1000 per hari telat
        }

        $pinjam->update([
            'tanggal_kembali' => $tgl_kembali,
            'status' => 'dikembalikan',
            'denda' => $denda // Simpan nominal denda
        ]);

        $pinjam->buku->increment('stok');

        if ($denda > 0) {
            return back()->with('success', "Buku dikembalikan. Anda telat $selisih_hari hari, denda: Rp " . number_format($denda));
        }

        return back()->with('success', 'Buku berhasil dikembalikan tepat waktu!');
    }
}