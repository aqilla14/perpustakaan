<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icon --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background:#f4f7fe;
            font-family:Arial, sans-serif;
        }

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

        .table-box{
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
        }

        .badge-custom{
            padding:8px 15px;
            border-radius:20px;
            font-size:14px;
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

        <a href="{{ route('dashboard') }}">
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
                    Riwayat Peminjaman
                </h4>

                <small class="text-muted">
                    Data riwayat peminjaman buku pengguna
                </small>

            </div>

            <div>

                <i class="bi bi-person-circle"></i>

                {{ auth()->user()->name }}

            </div>

        </div>


        {{-- TABLE --}}
        <div class="table-box">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4>
                    Data Riwayat
                </h4>

                <a href="{{ route('dashboard') }}"
                    class="btn btn-primary">

                    <i class="bi bi-arrow-left"></i>
                    Kembali

                </a>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>No</th>
                            <th>Nama Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>
                            <td>Laskar Pelangi</td>
                            <td>10 Mei 2026</td>
                            <td>17 Mei 2026</td>

                            <td>
                                <span class="badge bg-success badge-custom">
                                    Dikembalikan
                                </span>
                            </td>

                        </tr>


                        <tr>

                            <td>2</td>
                            <td>Atomic Habits</td>
                            <td>13 Mei 2026</td>
                            <td>-</td>

                            <td>
                                <span class="badge bg-warning text-dark badge-custom">
                                    Dipinjam
                                </span>
                            </td>

                        </tr>


                        <tr>

                            <td>3</td>
                            <td>Rich Dad Poor Dad</td>
                            <td>01 Mei 2026</td>
                            <td>08 Mei 2026</td>

                            <td>
                                <span class="badge bg-success badge-custom">
                                    Dikembalikan
                                </span>
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>
</html>