<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Administrator Perpustakaan',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'no_anggota' => 'ADM-001',
            'tgl_daftar' => Carbon::now(),
            'status' => 'aktif',
            'role' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $pengguna = [
            [
                'nama_lengkap' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'no_anggota' => 'PJG-2024001',
                'tgl_daftar' => Carbon::now()->subDays(30),
                'status' => 'aktif',
            ],
            [
                'nama_lengkap' => 'Siti Aminah',
                'email' => 'siti.aminah@example.com',
                'no_anggota' => 'PJG-2024002',
                'tgl_daftar' => Carbon::now()->subDays(28),
                'status' => 'aktif',
            ],
            [
                'nama_lengkap' => 'Agus Wijaya',
                'email' => 'agus.wijaya@example.com',
                'no_anggota' => 'PJG-2024003',
                'tgl_daftar' => Carbon::now()->subDays(25),
                'status' => 'aktif',
            ],
            [
                'nama_lengkap' => 'Dewi Lestari',
                'email' => 'dewi.lestari@example.com',
                'no_anggota' => 'PJG-2024004',
                'tgl_daftar' => Carbon::now()->subDays(20),
                'status' => 'aktif',
            ],
            [
                'nama_lengkap' => 'Rizki Fadillah',
                'email' => 'rizki.fadillah@example.com',
                'no_anggota' => 'PJG-2024005',
                'tgl_daftar' => Carbon::now()->subDays(15),
                'status' => 'aktif',
            ],
        ];

        foreach ($pengguna as $data) {
            User::create([
                'nama_lengkap' => $data['nama_lengkap'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'no_anggota' => $data['no_anggota'],
                'tgl_daftar' => $data['tgl_daftar'],
                'status' => $data['status'],
                'role' => 'pengguna',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}