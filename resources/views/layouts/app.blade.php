<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Perpustakaan - @yield('title')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
        }
        
        /* Sidebar Styles */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar .nav-link {
            color: #fff;
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .sidebar .nav-link i {
            width: 25px;
            margin-right: 10px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
        }
        
        /* Card Styles */
        .card-stats {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .card-stats:hover {
            transform: translateY(-5px);
        }
        
        /* Table Styles */
        .table-custom {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .table-custom thead {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }
        
        /* Book Card */
        .book-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .book-cover {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }
        
        .book-cover-placeholder {
            height: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        /* Badge Styles */
        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-disetujui { background-color: #17a2b8; color: #fff; }
        .badge-dipinjam { background-color: #007bff; color: #fff; }
        .badge-dikembalikan { background-color: #28a745; color: #fff; }
        .badge-ditolak { background-color: #dc3545; color: #fff; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .menu-toggle {
                display: block;
            }
        }
        
        /* Loading Spinner */
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        .loading.show {
            display: flex;
        }
        
        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        
        /* Search Box */
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding-left: 40px;
            border-radius: 50px;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="loading" id="loading">
        <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    @auth
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3">
            <div class="text-center mb-4">
                <i class="fas fa-book-open fa-3x text-white"></i>
                <h4 class="text-white mt-2">E-Perpustakaan</h4>
                <hr class="bg-white">
            </div>
            
            <div class="text-center mb-4">
                <div class="bg-white rounded-circle d-inline-flex p-2 mb-2">
                    <i class="fas fa-user-circle fa-3x text-primary"></i>
                </div>
                <p class="text-white mb-0"><strong>{{ auth()->user()->nama_lengkap }}</strong></p>
                <small class="text-white-50">
                    <i class="fas fa-tag"></i> {{ auth()->user()->no_anggota }}
                </small><br>
                <small class="text-white-50">
                    <i class="fas {{ auth()->user()->role == 'admin' ? 'fa-shield-alt' : 'fa-user' }}"></i>
                    {{ ucfirst(auth()->user()->role) }}
                </small>
            </div>
            
            <hr class="bg-white">
            
            <nav class="nav flex-column">
                @if(auth()->user()->role == 'admin')
                    <!-- Menu Admin -->
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.buku.index') }}" class="nav-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Manajemen Buku
                    </a>
                    <a href="{{ route('admin.penulis.index') }}" class="nav-link {{ request()->routeIs('admin.penulis.*') ? 'active' : '' }}">
                        <i class="fas fa-user-edit"></i> Manajemen Penulis
                    </a>
                    <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i> Manajemen Kategori
                    </a>
                    <a href="{{ route('admin.peminjaman.index') }}" class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding"></i> Manajemen Peminjaman
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> Laporan
                    </a>
                @else
                    <!-- Menu Pengguna -->
                    <a href="{{ route('pengguna.dashboard') }}" class="nav-link {{ request()->routeIs('pengguna.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                    <a href="{{ route('pengguna.buku.index') }}" class="nav-link {{ request()->routeIs('pengguna.buku.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Daftar Buku
                    </a>
                    <a href="{{ route('pengguna.peminjaman.status') }}" class="nav-link {{ request()->routeIs('pengguna.peminjaman.status') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i> Status Peminjaman
                    </a>
                    <a href="{{ route('pengguna.peminjaman.riwayat') }}" class="nav-link {{ request()->routeIs('pengguna.peminjaman.riwayat') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> Riwayat Peminjaman
                    </a>
                @endif
            </nav>
            
            <hr class="bg-white">
            
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Mobile Toggle Button -->
        <button class="btn btn-primary mb-3 d-md-none" id="menuToggle">
            <i class="fas fa-bars"></i> Menu
        </button>
        
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </div>
    @else
        @yield('content')
    @endauth
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Loading spinner
        $(document).ajaxStart(function() {
            $('#loading').addClass('show');
        }).ajaxStop(function() {
            $('#loading').removeClass('show');
        });
        
        // Mobile menu toggle
        $('#menuToggle').click(function() {
            $('#sidebar').toggleClass('active');
        });
        
        // Confirm delete
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data ini?');
        }
        
        // Auto close alert after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // DataTable initialization
        $(document).ready(function() {
            if ($('.datatable').length) {
                $('.datatable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>