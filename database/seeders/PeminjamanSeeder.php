<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'anggota')->get();
        $bukus = Buku::all();

        // ✅ CEK DATA WAJIB ADA
        if ($users->count() == 0 || $bukus->count() == 0) {
            return;
        }

        $peminjamanData = [];

        // 1. Pending
        for ($i = 0; $i < 5; $i++) {
            $peminjamanData[] = [
                'kode_peminjaman' => $this->generateKode(),
                'user_id' => $users->random()->id,
                'buku_id' => $bukus->random()->id,
                'tanggal_pinjam' => null,
                'jatuh_tempo' => null,
                'tanggal_kembali' => null,
                'status' => 'pending',
                'denda' => 0,
                'keterangan' => 'Pengajuan peminjaman',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 2. Disetujui
        for ($i = 0; $i < 5; $i++) {
            $pinjam = Carbon::now()->subDays(rand(1, 3));

            $peminjamanData[] = [
                'kode_peminjaman' => $this->generateKode(),
                'user_id' => $users->random()->id,
                'buku_id' => $bukus->random()->id,
                'tanggal_pinjam' => $pinjam,
                'jatuh_tempo' => $pinjam->copy()->addDays(7),
                'tanggal_kembali' => null,
                'status' => 'disetujui',
                'denda' => 0,
                'keterangan' => 'Menunggu pengambilan buku',
                'created_at' => $pinjam,
                'updated_at' => $pinjam,
            ];
        }

        // 3. Dipinjam
        for ($i = 0; $i < 5; $i++) {
            $pinjam = Carbon::now()->subDays(rand(2, 10));

            $peminjamanData[] = [
                'kode_peminjaman' => $this->generateKode(),
                'user_id' => $users->random()->id,
                'buku_id' => $bukus->random()->id,
                'tanggal_pinjam' => $pinjam,
                'jatuh_tempo' => $pinjam->copy()->addDays(7),
                'tanggal_kembali' => null,
                'status' => 'dipinjam',
                'denda' => 0,
                'keterangan' => 'Sedang dipinjam',
                'created_at' => $pinjam,
                'updated_at' => now(),
            ];
        }

        // 4. Dikembalikan
        for ($i = 0; $i < 5; $i++) {
            $pinjam = Carbon::now()->subDays(rand(10, 20));
            $kembali = $pinjam->copy()->addDays(rand(5, 12));

            $denda = $kembali->gt($pinjam->copy()->addDays(7))
                ? $pinjam->copy()->addDays(7)->diffInDays($kembali) * 1000
                : 0;

            $peminjamanData[] = [
                'kode_peminjaman' => $this->generateKode(),
                'user_id' => $users->random()->id,
                'buku_id' => $bukus->random()->id,
                'tanggal_pinjam' => $pinjam,
                'jatuh_tempo' => $pinjam->copy()->addDays(7),
                'tanggal_kembali' => $kembali,
                'status' => 'dikembalikan',
                'denda' => $denda,
                'keterangan' => 'Selesai',
                'created_at' => $pinjam,
                'updated_at' => $kembali,
            ];
        }

        // INSERT DATA
        foreach ($peminjamanData as $data) {
            Peminjaman::create($data);
        }
    }

    private function generateKode(): string
    {
        return 'PJM/' . date('Ymd') . '/' . strtoupper(substr(uniqid(), -5));
    }
}