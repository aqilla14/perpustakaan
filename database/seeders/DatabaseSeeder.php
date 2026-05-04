<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil semua seeder yang dibutuhkan
        $this->call([
            PenulisSeeder::class,
            KategoriSeeder::class,
            UserSeeder::class,
            BukuSeeder::class,
            PeminjamanSeeder::class,
        ]);
    }
}