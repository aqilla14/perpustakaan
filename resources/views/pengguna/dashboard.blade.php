<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icon --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f4f7fe;
            font-family:Arial, sans-serif;
        }

        /* SIDEBAR */

        .sidebar{
            width:250px;
            height:100vh;
            position:fixed;
            top:0;
            left:0;
            background:linear-gradient(180deg,#1e3c72,#2a5298);
            color:white;
            padding-top:20px;
        }

        .sidebar h3{
            text-align:center;
            margin-bottom:40px;
            font-weight:bold;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:15px 25px;
            transition:0.3s;
        }

        .sidebar a:hover{
            background:rgba(255,255,255,0.2);
            padding-left:30px;
        }

        /* CONTENT */

        .content{
            margin-left:250px;
            padding:30px;
        }

        .navbar-custom{
            background:white;
            padding:20px;
            border-radius:20px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
            margin-bottom:30px;
        }

        .welcome-box{
            background:linear-gradient(135deg,#667eea,#764ba2);
            color:white;
            padding:35px;
            border-radius:20px;
            margin-bottom:30px;
        }

        .card-dashboard{
            border:none;
            border-radius:20px;
            color:white;
            padding:25px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
            transition:0.3s;
        }

        .card-dashboard:hover{
            transform:translateY(-5px);
        }

        .bg-book{
            background:linear-gradient(135deg,#36d1dc,#5b86e5);
        }

        .bg-borrow{
            background:linear-gradient(135deg,#56ab2f,#a8e063);
        }

        .bg-history{
            background:linear-gradient(135deg,#ff9966,#ff5e62);
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

        .table-box{
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
            margin-top:40px;
        }

        @media(max-width:768px){

            .sidebar{
                width:100%;
                height:auto;
                position:relative;
            }

            .content{
                margin-left:0;
            }

        }

    </style>

</head>
<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">

        <h3>
            <i class="bi bi-book-half"></i>
            E-Perpus
        </h3>

        <a href="{{ route('pengguna.dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <a href="{{ route('pengguna.buku.index') }}">
            <i class="bi bi-book"></i>
            Data Buku
        </a>

        <a href="{{ route('pengguna.peminjaman.status') }}">
            <i class="bi bi-journal-check"></i>
            Status Peminjaman
        </a>

        <a href="{{ route('pengguna.peminjaman.riwayat') }}">
            <i class="bi bi-clock-history"></i>
            Riwayat
        </a>

        <a href="{{ route('pengguna.profil.index') }}">
            <i class="bi bi-person"></i>
            Profil
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button
                style="
                background:none;
                border:none;
                color:white;
                width:100%;
                text-align:left;
                padding:15px 25px;
                ">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </button>

        </form>

    </div>


    {{-- CONTENT --}}
    <div class="content">

        {{-- NAVBAR --}}
        <div class="navbar-custom d-flex justify-content-between align-items-center">

            <div>

                <h4 class="mb-0">
                    Dashboard Pengguna
                </h4>

                <small class="text-muted">
                    Selamat datang di E-Perpustakaan
                </small>

            </div>

            <div>

                <i class="bi bi-person-circle"></i>

                {{ auth()->user()->name }}

            </div>

        </div>


        {{-- WELCOME --}}
        <div class="welcome-box">

            <h2>
                Selamat Datang 👋
            </h2>

            <p>
                Cari buku favoritmu dan kelola peminjaman
                dengan mudah melalui sistem E-Perpustakaan.
            </p>

        </div>


        {{-- CARD --}}
        <div class="row g-4">

            <div class="col-md-4">

                <div class="card-dashboard bg-book">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5>Total Buku</h5>

                            <h2>250</h2>

                        </div>

                        <i class="bi bi-book fs-1"></i>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card-dashboard bg-borrow">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5>Sedang Dipinjam</h5>

                            <h2>2</h2>

                        </div>

                        <i class="bi bi-journal-arrow-down fs-1"></i>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card-dashboard bg-history">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5>Riwayat</h5>

                            <h2>12</h2>

                        </div>

                        <i class="bi bi-clock-history fs-1"></i>

                    </div>

                </div>

            </div>

        </div>


        {{-- BUKU --}}
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">

            <h3>Buku Populer</h3>

            <a href="{{ route('pengguna.buku.index') }}"
                class="btn btn-primary">

                <i class="bi bi-search"></i>
                Cari Buku

            </a>

        </div>


        <div class="row g-4">

            {{-- BUKU 1 --}}
            <div class="col-md-4">

                <div class="card book-card">

                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=1000"
                        class="book-img card-img-top">

                    <div class="card-body">

                        <h5>Laskar Pelangi</h5>

                        <p class="text-muted">
                            Andrea Hirata
                        </p>

                        <button class="btn btn-success w-100">
                            Pinjam Buku
                        </button>

                    </div>

                </div>

            </div>


            {{-- BUKU 2 --}}
            <div class="col-md-4">

                <div class="card book-card">

                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1000"
                        class="book-img card-img-top">

                    <div class="card-body">

                        <h5>Atomic Habits</h5>

                        <p class="text-muted">
                            James Clear
                        </p>

                        <button class="btn btn-success w-100">
                            Pinjam Buku
                        </button>

                    </div>

                </div>

            </div>


            {{-- BUKU 3 --}}
            <div class="col-md-4">

                <div class="card book-card">

                    <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=1000"
                        class="book-img card-img-top">

                    <div class="card-body">

                        <h5>Rich Dad Poor Dad</h5>

                        <p class="text-muted">
                            Robert Kiyosaki
                        </p>

                        <button class="btn btn-success w-100">
                            Pinjam Buku
                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- RIWAYAT --}}
        <div class="table-box">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4>
                    Riwayat Peminjaman
                </h4>

                <a href="{{ route('pengguna.peminjaman.riwayat') }}"
                    class="btn btn-primary btn-sm">

                    Lihat Semua

                </a>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>No</th>
                            <th>Nama Buku</th>
                            <th>Tanggal</th>
                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>
                            <td>Laskar Pelangi</td>
                            <td>13 Mei 2026</td>

                            <td>
                                <span class="badge bg-success">
                                    Dipinjam
                                </span>
                            </td>

                        </tr>

                        <tr>

                            <td>2</td>
                            <td>Atomic Habits</td>
                            <td>10 Mei 2026</td>

                            <td>
                                <span class="badge bg-primary">
                                    Dikembalikan
                                </span>
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>