<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background:#f4f7fe;
            font-family:Arial, sans-serif;
        }

        .navbar-custom{
            background:linear-gradient(90deg,#4e54c8,#8f94fb);
            padding:15px 30px;
        }

        .navbar-custom a{
            color:white;
            text-decoration:none;
            margin-right:20px;
            font-weight:500;
        }

        .book-card{
            border:none;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
            transition:0.3s;
        }

        .book-card:hover{
            transform:translateY(-5px);
        }

        .book-img{
            height:250px;
            object-fit:cover;
        }

    </style>

</head>
<body>

    {{-- NAVBAR --}}
    <div class="navbar-custom d-flex justify-content-between align-items-center">

        <div>

            <a href="{{ route('pengguna.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="{{ route('pengguna.buku.index') }}">
                <i class="bi bi-book"></i>
                Buku
            </a>

            <a href="{{ route('pengguna.peminjaman.status') }}">
                <i class="bi bi-journal-check"></i>
                Status
            </a>

            <a href="{{ route('pengguna.peminjaman.riwayat') }}">
                <i class="bi bi-clock-history"></i>
                Riwayat
            </a>

            <a href="{{ route('pengguna.profil.index') }}">
                <i class="bi bi-person"></i>
                Profil
            </a>

        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="btn btn-light btn-sm">
                Logout
            </button>

        </form>

    </div>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">
                    Koleksi Buku
                </h2>

                <p class="text-muted">
                    Temukan buku favoritmu di perpustakaan digital.
                </p>

            </div>

        </div>

        <div class="row g-4">

            @forelse($bukus as $buku)

            <div class="col-md-4">

                <div class="card book-card h-100">

                    <img
                        src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://via.placeholder.com/400x250' }}"
                        class="book-img w-100">

                    <div class="card-body">

                        <h5 class="fw-bold">
                            {{ $buku->judul }}
                        </h5>

                        <p class="mb-1 text-muted">
                            Penulis:
                            {{ $buku->penulis->nama ?? '-' }}
                        </p>

                        <p class="mb-1">
                            Kategori:
                            <span class="badge bg-primary">
                                {{ $buku->kategori->nama ?? '-' }}
                            </span>
                        </p>

                        <p class="mb-3">
                            Stok:
                            <span class="fw-bold">
                                {{ $buku->stok }}
                            </span>
                        </p>

                        <a href="{{ route('pengguna.buku.show', $buku->id) }}"
                            class="btn btn-primary w-100">

                            Detail Buku

                        </a>

                    </div>

                </div>

            </div>

            @empty

            <div class="col-12">

                <div class="alert alert-warning">

                    Buku belum tersedia.

                </div>

            </div>

            @endforelse

        </div>

    </div>

</body>
</html>