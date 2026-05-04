<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistik
        $totalDipinjam = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['dipinjam', 'disetujui'])
            ->count();
        
        $totalRiwayat = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dikembalikan')
            ->count();
        
        $totalDenda = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dikembalikan')
            ->sum('denda');
        
        $peminjamanAktif = Peminjaman::with(['buku.penulis'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['dipinjam', 'disetujui'])
            ->get();
        
        return view('pengguna.dashboard', compact(
            'totalDipinjam',
            'totalRiwayat',
            'totalDenda',
            'peminjamanAktif'
        ));
    }
}