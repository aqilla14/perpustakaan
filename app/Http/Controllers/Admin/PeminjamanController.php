<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku.penulis', 'buku.kategori']);
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $peminjamen = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Statistik
        $statistik = [
            'semua' => Peminjaman::count(),
            'pending' => Peminjaman::where('status', 'pending')->count(),
            'disetujui' => Peminjaman::where('status', 'disetujui')->count(),
            'dipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'dikembalikan' => Peminjaman::where('status', 'dikembalikan')->count(),
            'ditolak' => Peminjaman::where('status', 'ditolak')->count(),
        ];
        
        return view('admin.peminjaman.index', compact('peminjamen', 'statistik'));
    }

    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status != 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses!');
        }

        $buku = $peminjaman->buku;
        
        if (!$buku->kurangiStok(1)) {
            return redirect()->back()->with('error', 'Stok buku tidak mencukupi! (Stok tersedia: ' . $buku->stok . ')');
        }

        $tanggalPinjam = Carbon::now();
        $jatuhTempo = Carbon::now()->addDays(7);
        
        $peminjaman->update([
            'status' => 'disetujui',
            'tanggal_pinjam' => $tanggalPinjam,
            'jatuh_tempo' => $jatuhTempo,
            'keterangan' => 'Peminjaman disetujui oleh admin pada ' . $tanggalPinjam->format('d/m/Y H:i'),
        ]);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil disetujui! Buku harus diambil dalam 3 hari.');
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status != 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses!');
        }

        $request->validate([
            'alasan_tolak' => 'nullable|string|max:500',
        ]);

        $peminjaman->update([
            'status' => 'ditolak',
            'keterangan' => $request->alasan_tolak ?? 'Peminjaman ditolak oleh admin karena persyaratan tidak terpenuhi',
        ]);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditolak!');
    }

    public function markAsBorrowed(Peminjaman $peminjaman)
    {
        if ($peminjaman->status != 'disetujui') {
            return redirect()->back()->with('error', 'Status peminjaman tidak valid untuk proses ini!');
        }
        
        // Cek apakah sudah melewati batas ambil (3 hari)
        $batasAmbil = Carbon::parse($peminjaman->tanggal_pinjam)->addDays(3);
        if (Carbon::now()->gt($batasAmbil)) {
            return redirect()->back()->with('error', 'Batas waktu pengambilan buku telah lewat! Peminjaman dibatalkan.');
        }

        $peminjaman->update([
            'status' => 'dipinjam',
            'keterangan' => 'Buku telah diambil oleh anggota pada ' . Carbon::now()->format('d/m/Y H:i'),
        ]);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Buku sudah diambil oleh anggota! Status berubah menjadi Dipinjam.');
    }

    public function returnBook(Peminjaman $peminjaman)
    {
        if ($peminjaman->status != 'dipinjam') {
            return redirect()->back()->with('error', 'Buku sedang tidak dalam status dipinjam!');
        }

        $tanggalKembali = Carbon::now();
        $denda = $peminjaman->hitungDenda();
        
        // Update status dan stok
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => $tanggalKembali,
            'denda' => $denda,
            'keterangan' => 'Buku dikembalikan pada ' . $tanggalKembali->format('d/m/Y H:i') . 
                           ($denda > 0 ? '. Denda yang harus dibayar: Rp ' . number_format($denda, 0, ',', '.') : ''),
        ]);

        // Kembalikan stok buku
        $peminjaman->buku->tambahStok(1);

        $message = 'Buku berhasil dikembalikan!';
        if ($denda > 0) {
            $hariTerlambat = Carbon::parse($peminjaman->jatuh_tempo)->diffInDays($tanggalKembali);
            $message .= ' Terlambat ' . $hariTerlambat . ' hari. Denda: Rp ' . number_format($denda, 0, ',', '.');
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', $message);
    }
    
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'buku.penulis', 'buku.kategori']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }
    
    public function destroy(Peminjaman $peminjaman)
    {
        // Hanya bisa hapus peminjaman dengan status pending/ditolak
        if (!in_array($peminjaman->status, ['pending', 'ditolak'])) {
            return redirect()->back()->with('error', 'Peminjaman dengan status ' . $peminjaman->status . ' tidak dapat dihapus!');
        }
        
        $peminjaman->delete();
        
        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus!');
    }
}