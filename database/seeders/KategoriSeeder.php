<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Carbon\Carbon;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            [
                'nama_kategori' => 'Fiksi',
                'deskripsi' => 'Buku cerita fiksi yang mengangkat imajinasi dan kreativitas penulis. Berbagai genre seperti fantasi, misteri, romantis, dan petualangan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Non-Fiksi',
                'deskripsi' => 'Buku berdasarkan fakta dan kejadian nyata. Berisi informasi, pengetahuan, atau dokumentasi tentang suatu topik.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Pendidikan',
                'deskripsi' => 'Buku pelajaran dan referensi pendidikan untuk berbagai jenjang. Termasuk buku akademik, modul, dan panduan belajar.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Teknologi',
                'deskripsi' => 'Buku tentang teknologi informasi, pemrograman, artificial intelligence, dan perkembangan teknologi terbaru.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Agama',
                'deskripsi' => 'Buku keagamaan, spiritualitas, dan pengembangan diri berdasarkan nilai-nilai agama.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Biografi',
                'deskripsi' => 'Buku kisah hidup seseorang, tokoh terkenal, pejuang, atau inspirator yang menginspirasi.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Bisnis',
                'deskripsi' => 'Buku tentang manajemen, kewirausahaan, pemasaran, dan pengembangan bisnis.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Kesehatan',
                'deskripsi' => 'Buku tentang kesehatan, gaya hidup sehat, nutrisi, dan pengobatan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Seni & Budaya',
                'deskripsi' => 'Buku tentang seni, musik, tari, lukisan, dan kebudayaan tradisional maupun modern.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Komputer',
                'deskripsi' => 'Buku tentang hardware, software, jaringan, dan ilmu komputer lainnya.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($kategori as $data) {
            Kategori::create($data);
        }
    }
}