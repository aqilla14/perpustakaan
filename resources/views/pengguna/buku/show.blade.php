<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background:#f4f7fe;
            font-family:Arial, sans-serif;
        }

        .detail-box{
            background:white;
            border-radius:20px;
            padding:30px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
        }

        .book-cover{
            width:100%;
            border-radius:15px;
            height:450px;
            object-fit:cover;
        }

    </style>

</head>
<body>

    <div class="container py-5">

        <a href="{{ route('pengguna.buku.index') }}"
            class="btn btn-primary mb-4">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

        <div class="detail-box">

            <div class="row">

                <div class="col-md-4">

                    <img
                        src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://via.placeholder.com/400x500' }}"
                        class="book-cover">

                </div>

                <div class="col-md-8">

                    <h2 class="fw-bold mb-3">
                        {{ $buku->judul }}
                    </h2>

                    <p>
                        <strong>Penulis:</strong>
                        {{ $buku->penulis->nama ?? '-' }}
                    </p>

                    <p>
                        <strong>Kategori:</strong>
                        {{ $buku->kategori->nama ?? '-' }}
                    </p>

                    <p>
                        <strong>Tahun Terbit:</strong>
                        {{ $buku->tahun_terbit }}
                    </p>

                    <p>
                        <strong>Stok:</strong>
                        {{ $buku->stok }}
                    </p>

                    <hr>

                    <h5>
                        Deskripsi
                    </h5>

                    <p class="text-muted">
                        {{ $buku->deskripsi ?? 'Tidak ada deskripsi buku.' }}
                    </p>

                    <form action="{{ route('pengguna.peminjaman.ajukan', $buku->id) }}"
                        method="POST">

                        @csrf

                        <button class="btn btn-success mt-3">

                            <i class="bi bi-bookmark-check"></i>
                            Pinjam Buku

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>
</html>