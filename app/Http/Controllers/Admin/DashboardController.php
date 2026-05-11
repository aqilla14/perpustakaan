<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard
        $totalBuku = Buku::count();
        $totalAnggota = User::where('role', 'pengguna')->count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
        $peminjamanMenunggu = Peminjaman::where('status', 'pending')->count();
        $peminjamanTerlambat = Peminjaman::where('status', 'dipinjam')
            ->where('jatuh_tempo', '<', Carbon::now())
            ->count();
        
        // Data untuk grafik (7 hari terakhir)
        $peminjamanPerHari = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            $peminjamanPerHari[] = Peminjaman::whereDate('created_at', $tanggal)->count();
        }
        
        // Buku terpopuler
        $bukuTerpopuler = Peminjaman::select('buku_id')
            ->with('buku')
            ->groupBy('buku_id')
            ->selectRaw('count(*) as total')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'peminjamanAktif',
            'peminjamanMenunggu',
            'peminjamanTerlambat',
            'peminjamanPerHari',
            'bukuTerpopuler'
        ));
    }
}