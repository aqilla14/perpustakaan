<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku.penulis', 'buku.kategori']);
        
        // Filter berdasarkan rentang tanggal
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
            $startDate = $request->start_date;
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
            $endDate = $request->end_date;
        }
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status && $request->status != 'semua') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        $peminjamen = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Statistik laporan
        $statistik = [
            'total_peminjaman' => $query->count(),
            'total_denda' => $query->sum('denda'),
            'total_selesai' => (clone $query)->where('status', 'dikembalikan')->count(),
            'total_dipinjam' => (clone $query)->where('status', 'dipinjam')->count(),
            'total_terlambat' => (clone $query)->where('status', 'dipinjam')
                                ->where('jatuh_tempo', '<', Carbon::now())->count(),
            'rata_rata_hari' => 0,
        ];
        
        // Hitung rata-rata lama peminjaman untuk yang sudah dikembalikan
        $selesaiList = (clone $query)->where('status', 'dikembalikan')->get();
        if ($selesaiList->count() > 0) {
            $totalHari = 0;
            foreach ($selesaiList as $pinjam) {
                $lamaPinjam = Carbon::parse($pinjam->tanggal_pinjam)->diffInDays(Carbon::parse($pinjam->tanggal_kembali));
                $totalHari += $lamaPinjam;
            }
            $statistik['rata_rata_hari'] = round($totalHari / $selesaiList->count(), 1);
        }
        
        // Data untuk grafik
        $grafikData = [];
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = $start->diffInDays($end) + 1;
        
        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i);
            $grafikData[] = [
                'tanggal' => $date->format('Y-m-d'),
                'jumlah' => Peminjaman::whereDate('created_at', $date)->count(),
            ];
        }
        
        // Daftar user untuk filter
        $users = User::where('role', 'anggota')->orderBy('name')->get();
        
        return view('admin.laporan.index', compact(
            'peminjamen', 
            'statistik', 
            'grafikData',
            'users',
            'startDate',
            'endDate'
        ));
    }
    
    public function export(Request $request)
    {
        // Ekspor ke Excel (menggunakan Laravel Excel atau CSV sederhana)
        $peminjamen = Peminjaman::with(['user', 'buku'])
            ->when($request->start_date, function($q) use ($request) {
                return $q->whereDate('created_at', '>=', $request->start_date);
            })
            ->when($request->end_date, function($q) use ($request) {
                return $q->whereDate('created_at', '<=', $request->end_date);
            })
            ->get();
        
        // Generate CSV
        $filename = 'laporan_peminjaman_' . Carbon::now()->format('Ymd_His') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // Header CSV
        fputcsv($handle, [
            'Kode Peminjaman',
            'Nama Anggota',
            'Email',
            'Judul Buku',
            'Tanggal Pinjam',
            'Jatuh Tempo',
            'Tanggal Kembali',
            'Status',
            'Denda'
        ]);
        
        // Data
        foreach ($peminjamen as $pinjam) {
            fputcsv($handle, [
                $pinjam->kode_peminjaman,
                $pinjam->user->name,
                $pinjam->user->email,
                $pinjam->buku->judul,
                $pinjam->tanggal_pinjam ? Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') : '-',
                $pinjam->jatuh_tempo ? Carbon::parse($pinjam->jatuh_tempo)->format('d/m/Y') : '-',
                $pinjam->tanggal_kembali ? Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') : '-',
                $pinjam->status,
                'Rp ' . number_format($pinjam->denda, 0, ',', '.')
            ]);
        }
        
        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);
        
        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    
    public function print(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku.penulis', 'buku.kategori']);
        
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $peminjamen = $query->orderBy('created_at', 'desc')->get();
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        
        return view('admin.laporan.print', compact('peminjamen', 'startDate', 'endDate'));
    }
}