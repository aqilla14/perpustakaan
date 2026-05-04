<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function ajukan(Request $request, Buku $buku)
    {
        // Cek stok
        if (!$buku->isTersedia()) {
            return redirect()->back()->with('error', 'Maaf, stok buku tidak tersedia!');
        }
        
        // Cek apakah user sudah meminjam buku ini
        $existingActive = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
            ->first();
            
        if ($existingActive) {
            $statusText = [
                'pending' => 'menunggu persetujuan',
                'disetujui' => 'menunggu diambil',
                'dipinjam' => 'sedang dipinjam'
            ];
            return redirect()->back()->with('error', 'Anda sudah ' . ($statusText[$existingActive->status] ?? 'memproses') . ' buku ini!');
        }
        
        // Cek batas peminjaman aktif (maksimal 3 buku)
        $aktifCount = Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->count();
            
        if ($aktifCount >= 3) {
            return redirect()->back()->with('error', 'Maaf, Anda hanya dapat meminjam maksimal 3 buku sekaligus!');
        }
        
        // Buat pengajuan peminjaman
        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => Peminjaman::generateKodePeminjaman(),
            'user_id' => Auth::id(),
            'buku_id' => $buku->id,
            'status' => 'pending',
            'keterangan' => 'Pengajuan peminjaman pada ' . Carbon::now()->format('d/m/Y H:i'),
        ]);
        
        return redirect()->route('anggota.peminjaman.status')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim! Kode: ' . $peminjaman->kode_peminjaman);
    }
    
    public function status()
    {
        $peminjamen = Peminjaman::with(['buku.penulis', 'buku.kategori'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Hitung denda untuk yang terlambat
        foreach ($peminjamen as $pinjam) {
            if ($pinjam->status == 'dipinjam' && $pinjam->isTerlambat()) {
                $pinjam->denda_sementara = $pinjam->hitungDenda();
            }
        }
            
        return view('anggota.peminjaman.status', compact('peminjamen'));
    }
    
    public function riwayat(Request $request)
    {
        $query = Peminjaman::with(['buku.penulis', 'buku.kategori'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['dikembalikan', 'ditolak']);
            
        // Filter tahun
        if ($request->has('tahun') && $request->tahun) {
            $query->whereYear('created_at', $request->tahun);
        }
        
        $riwayat = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistik riwayat
        $statistik = [
            'total_peminjaman' => Peminjaman::where('user_id', Auth::id())->count(),
            'total_selesai' => Peminjaman::where('user_id', Auth::id())->where('status', 'dikembalikan')->count(),
            'total_denda' => Peminjaman::where('user_id', Auth::id())->where('status', 'dikembalikan')->sum('denda'),
            'buku_favorit' => Peminjaman::where('user_id', Auth::id())
                ->where('status', 'dikembalikan')
                ->select('buku_id')
                ->groupBy('buku_id')
                ->selectRaw('count(*) as total, buku_id')
                ->with('buku')
                ->orderBy('total', 'desc')
                ->first(),
        ];
        
        $tahunList = Peminjaman::where('user_id', Auth::id())
            ->selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        return view('anggota.peminjaman.riwayat', compact('riwayat', 'statistik', 'tahunList'));
    }
    
    public function batal(Peminjaman $peminjaman)
    {
        // Hanya bisa membatalkan yang masih pending
        if ($peminjaman->status != 'pending') {
            return redirect()->back()->with('error', 'Peminjaman tidak dapat dibatalkan karena sudah ' . $peminjaman->status);
        }
        
        // Cek kepemilikan
        if ($peminjaman->user_id != Auth::id()) {
            abort(403);
        }
        
        $peminjaman->update([
            'status' => 'ditolak',
            'keterangan' => 'Dibatalkan oleh anggota pada ' . Carbon::now()->format('d/m/Y H:i'),
        ]);
        
        return redirect()->route('anggota.peminjaman.status')
            ->with('success', 'Pengajuan peminjaman berhasil dibatalkan!');
    }
    
    public function perpanjang(Peminjaman $peminjaman)
    {
        // Cek apakah bisa diperpanjang
        if ($peminjaman->status != 'dipinjam') {
            return redirect()->back()->with('error', 'Hanya peminjaman aktif yang dapat diperpanjang!');
        }
        
        // Cek apakah sudah diperpanjang sebelumnya
        if ($peminjaman->keterangan && str_contains($peminjaman->keterangan, 'Diperpanjang')) {
            return redirect()->back()->with('error', 'Maksimal perpanjangan hanya 1 kali!');
        }
        
        // Cek apakah sudah melewati jatuh tempo
        if (Carbon::now()->gt($peminjaman->jatuh_tempo)) {
            return redirect()->back()->with('error', 'Tidak dapat memperpanjang karena sudah melewati batas waktu!');
        }
        
        // Perpanjang 7 hari dari jatuh tempo
        $jatuhTempoBaru = Carbon::parse($peminjaman->jatuh_tempo)->addDays(7);
        
        $peminjaman->update([
            'jatuh_tempo' => $jatuhTempoBaru,
            'keterangan' => ($peminjaman->keterangan ? $peminjaman->keterangan . "\n" : '') . 
                           'Diperpanjang pada ' . Carbon::now()->format('d/m/Y H:i') . 
                           '. Jatuh tempo baru: ' . $jatuhTempoBaru->format('d/m/Y'),
        ]);
        
        return redirect()->route('anggota.peminjaman.status')
            ->with('success', 'Peminjaman berhasil diperpanjang! Jatuh tempo baru: ' . $jatuhTempoBaru->format('d/m/Y'));
    }
}