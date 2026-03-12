<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function dashboard() {
        $bukus = Buku::all();
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

    // Melakukan Peminjaman
    public function pinjamBuku(Request $request) {
        $buku = Buku::findOrFail($request->buku_id);

        // Validasi stok (Biar nggak minus)
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now(),
            'status' => 'dipinjam'
        ]);

        // Kurangi stok buku
        $buku->decrement('stok');

        return redirect()->route('siswa.pinjam')->with('success', 'Buku berhasil dipinjam!');
    }

    // Melakukan Pengembalian
    public function kembaliBuku($id) {
        $pinjam = Peminjaman::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $pinjam->update([
            'tanggal_kembali' => now(),
            'status' => 'dikembalikan'
        ]);

        // Tambah stok buku balik
        $pinjam->buku->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan!');
    }
}