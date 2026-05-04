<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penulis;
use Carbon\Carbon;

class PenulisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penulis = [
            [
                'nama_penulis' => 'Tere Liye',
                'bio' => 'Penulis novel terkenal asal Indonesia. Lahir di Lahat, Sumatera Selatan. Karyanya banyak mengangkat tema tentang kehidupan, keluarga, dan petualangan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_penulis' => 'Andrea Hirata',
                'bio' => 'Penulis novel Laskar Pelangi yang fenomenal. Lahir di Belitung, Indonesia. Karyanya banyak mengangkat kisah inspiratif tentang pendidikan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_penulis' => 'Pramoedya Ananta Toer',
                'bio' => 'Sastrawan legendaris Indonesia. Lahir di Blora, Jawa Tengah. Karyanya banyak mengangkat sejarah perjuangan bangsa Indonesia.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_penulis' => 'Raditya Dika',
                'bio' => 'Penulis buku komedi, aktor, dan sutradara asal Indonesia. Gaya penulisannya yang humoris dan dekat dengan anak muda.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_penulis' => 'Dewi Lestari',
                'bio' => 'Penulis novel dan penyanyi. Karyanya seperti Supernova dan Filosofi Kopi sangat populer di kalangan pembaca Indonesia.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_penulis' => 'Habiburrahman El Shirazy',
                'bio' => 'Penulis novel religi yang terkenal dengan karyanya Ayat-Ayat Cinta. Lahir di Semarang, Jawa Tengah.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_penulis' => 'Mira W.',
                'bio' => 'Penulis novel roman yang sangat produktif. Karyanya banyak diadaptasi menjadi sinetron dan film.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_penulis' => 'Ayuwidya',
                'bio' => 'Penulis buku remaja dan novel populer. Karyanya banyak disukai oleh kalangan muda.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_penulis' => 'Risa Saraswati',
                'bio' => 'Penulis buku horor dan misteri. Karyanya terkenal dengan cerita-cerita horor yang mencekam.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_penulis' => 'Boy Candra',
                'bio' => 'Penulis buku puisi dan novel. Gaya penulisannya puitis dan menyentuh hati.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($penulis as $data) {
            Penulis::create($data);
        }
    }
}