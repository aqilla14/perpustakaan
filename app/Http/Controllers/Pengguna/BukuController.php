<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penulis;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with(['penulis', 'kategori'])->where('stok', '>', 0);
        
        // Fitur pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%")
                  ->orWhereHas('penulis', function($q2) use ($search) {
                      $q2->where('nama_penulis', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }
        
        // Filter berdasarkan penulis
        if ($request->has('penulis') && $request->penulis) {
            $query->where('penulis_id', $request->penulis);
        }
        
        // Filter tahun terbit
        if ($request->has('tahun') && $request->tahun) {
            $query->where('tahun_terbit', $request->tahun);
        }
        
        // Sorting
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'terlama':
                $query->orderBy('tahun_terbit', 'asc');
                break;
            case 'judul_az':
                $query->orderBy('judul', 'asc');
                break;
            case 'judul_za':
                $query->orderBy('judul', 'desc');
                break;
            case 'stok_terbanyak':
                $query->orderBy('stok', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }
        
        $bukus = $query->paginate(12);
        $kategoris = Kategori::all();
        $penulisList = Penulis::all();
        $tahunList = Buku::select('tahun_terbit')->distinct()->orderBy('tahun_terbit', 'desc')->pluck('tahun_terbit');
        
        // Simpan filter untuk pagination
        $bukus->appends($request->all());
        
        return view('anggota.buku.index', compact(
            'bukus', 
            'kategoris', 
            'penulisList',
            'tahunList'
        ));
    }

    public function show(Buku $buku)
    {
        $buku->load(['penulis', 'kategori']);
        
        // Cek apakah user sedang meminjam buku ini
        $sedangMeminjam = false;
        $pengajuanPending = false;
        
        if (auth()->check()) {
            $sedangMeminjam = $buku->peminjamen()
                ->where('user_id', auth()->id())
                ->whereIn('status', ['disetujui', 'dipinjam'])
                ->exists();
                
            $pengajuanPending = $buku->peminjamen()
                ->where('user_id', auth()->id())
                ->where('status', 'pending')
                ->exists();
        }
        
        // Rekomendasi buku serupa
        $rekomendasi = Buku::with('penulis')
            ->where('kategori_id', $buku->kategori_id)
            ->where('id', '!=', $buku->id)
            ->where('stok', '>', 0)
            ->limit(4)
            ->get();
        
        return view('anggota.buku.show', compact(
            'buku', 
            'sedangMeminjam', 
            'pengajuanPending',
            'rekomendasi'
        ));
    }
}