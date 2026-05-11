<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Perpustakaan Digital - Temukan ribuan koleksi buku dan literatur terbaik">
    <title>Perpustakaan Digital | Temukan Pengetahuan Baru</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom配置 Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <!-- NAVBAR -->
    @if (Route::has('login'))
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <i class="fas fa-book-open text-2xl text-indigo-600"></i>
                    <span class="font-bold text-xl text-gray-800">Digital Library</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600 transition px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 transition px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white hover:bg-indigo-700 transition px-4 py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    @endif


    <!-- MAIN CONTENT -->
    <div class="min-h-screen bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-700">

        <!-- HERO SECTION -->
        <section class="pt-28 lg:pt-32 pb-16 px-4">
            <div class="max-w-7xl mx-auto text-center">
                <div class="animate-float mb-6">
                    <i class="fas fa-book-reader text-6xl text-white/90"></i>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-fade-in-up">
                    Selamat Datang di
                    <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                        Perpustakaan Digital
                    </span>
                </h1>
                
                <p class="text-lg md:text-xl text-white/90 mb-8 max-w-2xl mx-auto animate-fade-in-up delay-100">
                    Temukan ribuan koleksi buku, jurnal, dan literatur terbaik. 
                    Tingkatkan pengetahuan Anda bersama kami.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up delay-200">
                    <a href="#" class="inline-flex items-center justify-center px-6 py-3 bg-white text-indigo-600 font-semibold rounded-full hover:bg-gray-100 transition shadow-lg hover:shadow-xl">
                        <i class="fas fa-search mr-2"></i>Jelajahi Koleksi
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-full hover:bg-white/30 transition">
                        <i class="fas fa-info-circle mr-2"></i>Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </section>


        <!-- STATS SECTION -->
        <section class="max-w-7xl mx-auto px-4 pb-16">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition hover:-translate-y-1">
                    <i class="fas fa-book text-4xl text-indigo-600 mb-3"></i>
                    <h2 class="text-3xl font-bold text-gray-800">10,000+</h2>
                    <p class="text-gray-600 mt-1">Koleksi Buku</p>
                </div>

                <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition hover:-translate-y-1">
                    <i class="fas fa-users text-4xl text-indigo-600 mb-3"></i>
                    <h2 class="text-3xl font-bold text-gray-800">5,000+</h2>
                    <p class="text-gray-600 mt-1">Anggota Aktif</p>
                </div>

                <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition hover:-translate-y-1">
                    <i class="fas fa-clock text-4xl text-indigo-600 mb-3"></i>
                    <h2 class="text-3xl font-bold text-gray-800">24/7</h2>
                    <p class="text-gray-600 mt-1">Layanan Digital</p>
                </div>
            </div>
        </section>


        <!-- FEATURES SECTION -->
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Layanan Unggulan</h2>
                    <p class="text-lg text-gray-600">Kemudahan akses pengetahuan untuk Anda</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-gray-50 rounded-xl p-6 text-center hover:shadow-lg transition">
                        <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Pencarian Cepat</h3>
                        <p class="text-gray-600 text-sm">Temukan buku dengan sistem pencarian canggih</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6 text-center hover:shadow-lg transition">
                        <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-mobile-alt text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Akses Mobile</h3>
                        <p class="text-gray-600 text-sm">Baca kapan saja, di mana saja</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6 text-center hover:shadow-lg transition">
                        <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-headset text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Layanan 24/7</h3>
                        <p class="text-gray-600 text-sm">Tim support siap membantu Anda</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6 text-center hover:shadow-lg transition">
                        <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-calendar-alt text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Peminjaman Online</h3>
                        <p class="text-gray-600 text-sm">Pinjam tanpa perlu datang ke perpustakaan</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- LATEST COLLECTION SECTION -->
        <section class="bg-gradient-to-br from-gray-50 to-indigo-50 py-20">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Koleksi Terbaru</h2>
                    <p class="text-lg text-gray-600">Buku-buku pilihan editor kami</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Book 1 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition">
                        <div class="h-40 bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-book text-white text-5xl"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1">Pemrograman Web</h3>
                            <p class="text-sm text-gray-500 mb-2">John Doe</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Tersedia</span>
                                <i class="fas fa-heart text-gray-300 hover:text-red-500 cursor-pointer transition"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Book 2 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition">
                        <div class="h-40 bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                            <i class="fas fa-chart-line text-white text-5xl"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1">Data Science</h3>
                            <p class="text-sm text-gray-500 mb-2">Jane Smith</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Tersedia</span>
                                <i class="fas fa-heart text-gray-300 hover:text-red-500 cursor-pointer transition"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Book 3 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition">
                        <div class="h-40 bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center">
                            <i class="fas fa-brain text-white text-5xl"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1">AI & Machine Learning</h3>
                            <p class="text-sm text-gray-500 mb-2">Alan Turing</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">Dipinjam</span>
                                <i class="fas fa-heart text-gray-300 hover:text-red-500 cursor-pointer transition"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Book 4 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition">
                        <div class="h-40 bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center">
                            <i class="fas fa-code text-white text-5xl"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1">Laravel Framework</h3>
                            <p class="text-sm text-gray-500 mb-2">Taylor Otwell</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Tersedia</span>
                                <i class="fas fa-heart text-gray-300 hover:text-red-500 cursor-pointer transition"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-10">
                    <a href="#" class="text-indigo-600 hover:text-indigo-700 font-semibold inline-flex items-center">
                        Lihat Semua Koleksi
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </section>


        <!-- CTA SECTION -->
        <section class="bg-gradient-to-r from-indigo-600 to-purple-600 py-16">
            <div class="max-w-4xl mx-auto text-center px-4">
                <h2 class="text-3xl font-bold text-white mb-4">Siap Menjadi Anggota Perpustakaan Kami?</h2>
                <p class="text-indigo-100 mb-8">Daftar sekarang dan nikmati akses tak terbatas ke ribuan koleksi buku terbaik</p>
                <a href="{{ route('register') }}" class="inline-flex items-center bg-white text-indigo-600 hover:bg-gray-100 transition px-8 py-3 rounded-full font-semibold shadow-lg">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </a>
            </div>
        </section>


        <!-- FOOTER -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <i class="fas fa-book-open text-2xl text-indigo-400"></i>
                            <span class="font-bold text-xl">Digital Library</span>
                        </div>
                        <p class="text-gray-400 text-sm">Membangun generasi cerdas melalui akses pengetahuan yang mudah dan menyenangkan.</p>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold mb-4">Tautan Cepat</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-white transition">Beranda</a></li>
                            <li><a href="#" class="hover:text-white transition">Koleksi</a></li>
                            <li><a href="#" class="hover:text-white transition">Layanan</a></li>
                            <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold mb-4">Layanan</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-white transition">Peminjaman Online</a></li>
                            <li><a href="#" class="hover:text-white transition">E-Book</a></li>
                            <li><a href="#" class="hover:text-white transition">Ruangan Baca</a></li>
                            <li><a href="#" class="hover:text-white transition">Diskusi Online</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold mb-4">Hubungi Kami</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><i class="fas fa-map-marker-alt mr-2"></i> Jl. Pendidikan No. 123</li>
                            <li><i class="fas fa-phone mr-2"></i> (021) 1234-5678</li>
                            <li><i class="fas fa-envelope mr-2"></i> info@digitallibrary.com</li>
                        </ul>
                        <div class="flex space-x-4 mt-4">
                            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} Digital Library. All rights reserved. | Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }}</p>
                </div>
            </div>
        </footer>
    </div>

</body>
</html>