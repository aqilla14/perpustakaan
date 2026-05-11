<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('pengguna.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');
    
    Route::resource('buku', App\Http\Controllers\Admin\BukuController::class);
    
    Route::get('penulis', [App\Http\Controllers\Admin\PenulisController::class, 'index'])
        ->name('penulis.index');
    Route::post('penulis', [App\Http\Controllers\Admin\PenulisController::class, 'store'])
        ->name('penulis.store');
    Route::put('penulis/{penulis}', [App\Http\Controllers\Admin\PenulisController::class, 'update'])
        ->name('penulis.update');
    Route::delete('penulis/{penulis}', [App\Http\Controllers\Admin\PenulisController::class, 'destroy'])
        ->name('penulis.destroy');
    
    Route::get('kategori', [App\Http\Controllers\Admin\KategoriController::class, 'index'])
        ->name('kategori.index');
    Route::post('kategori', [App\Http\Controllers\Admin\KategoriController::class, 'store'])
        ->name('kategori.store');
    Route::put('kategori/{kategori}', [App\Http\Controllers\Admin\KategoriController::class, 'update'])
        ->name('kategori.update');
    Route::delete('kategori/{kategori}', [App\Http\Controllers\Admin\KategoriController::class, 'destroy'])
        ->name('kategori.destroy');
    
    Route::get('peminjaman', [App\Http\Controllers\Admin\PeminjamanController::class, 'index'])
        ->name('peminjaman.index');
    Route::get('peminjaman/{peminjaman}', [App\Http\Controllers\Admin\PeminjamanController::class, 'show'])
        ->name('peminjaman.show');
    Route::post('peminjaman/{peminjaman}/approve', [App\Http\Controllers\Admin\PeminjamanController::class, 'approve'])
        ->name('peminjaman.approve');
    Route::post('peminjaman/{peminjaman}/reject', [App\Http\Controllers\Admin\PeminjamanController::class, 'reject'])
        ->name('peminjaman.reject');
    Route::post('peminjaman/{peminjaman}/borrowed', [App\Http\Controllers\Admin\PeminjamanController::class, 'markAsBorrowed'])
        ->name('peminjaman.borrowed');
    Route::post('peminjaman/{peminjaman}/return', [App\Http\Controllers\Admin\PeminjamanController::class, 'returnBook'])
        ->name('peminjaman.return');
    Route::delete('peminjaman/{peminjaman}', [App\Http\Controllers\Admin\PeminjamanController::class, 'destroy'])
        ->name('peminjaman.destroy');
    
    Route::get('laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])
        ->name('laporan.index');
    Route::get('laporan/export', [App\Http\Controllers\Admin\LaporanController::class, 'export'])
        ->name('laporan.export');
    Route::get('laporan/print', [App\Http\Controllers\Admin\LaporanController::class, 'print'])
        ->name('laporan.print');
    
    Route::get('anggota', [App\Http\Controllers\Admin\AnggotaController::class, 'index'])
        ->name('anggota.index');
    Route::get('anggota/{user}', [App\Http\Controllers\Admin\AnggotaController::class, 'show'])
        ->name('anggota.show');
    Route::put('anggota/{user}', [App\Http\Controllers\Admin\AnggotaController::class, 'update'])
        ->name('anggota.update');
    Route::post('anggota/{user}/status', [App\Http\Controllers\Admin\AnggotaController::class, 'updateStatus'])
        ->name('anggota.status');
    Route::delete('anggota/{user}', [App\Http\Controllers\Admin\AnggotaController::class, 'destroy'])
        ->name('anggota.destroy');
});

Route::middleware(['auth', 'role:pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    
    Route::get('/dashboard', [App\Http\Controllers\Pengguna\DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('buku', [App\Http\Controllers\Pengguna\BukuController::class, 'index'])
        ->name('buku.index');
    Route::get('buku/{buku}', [App\Http\Controllers\Pengguna\BukuController::class, 'show'])
        ->name('buku.show');
    
    Route::post('buku/{buku}/pinjam', [App\Http\Controllers\Pengguna\PeminjamanController::class, 'ajukan'])
        ->name('peminjaman.ajukan');
    Route::get('peminjaman/status', [App\Http\Controllers\Pengguna\PeminjamanController::class, 'status'])
        ->name('peminjaman.status');
    Route::get('peminjaman/riwayat', [App\Http\Controllers\Pengguna\PeminjamanController::class, 'riwayat'])
        ->name('peminjaman.riwayat');
    Route::post('peminjaman/{peminjaman}/batal', [App\Http\Controllers\Pengguna\PeminjamanController::class, 'batal'])
        ->name('peminjaman.batal');
    Route::post('peminjaman/{peminjaman}/perpanjang', [App\Http\Controllers\Pengguna\PeminjamanController::class, 'perpanjang'])
        ->name('peminjaman.perpanjang');
    

    Route::get('profil', [App\Http\Controllers\Pengguna\ProfilController::class, 'index'])
        ->name('profil.index');
    Route::put('profil', [App\Http\Controllers\Pengguna\ProfilController::class, 'update'])
        ->name('profil.update');
    Route::put('profil/password', [App\Http\Controllers\Pengguna\ProfilController::class, 'updatePassword'])
        ->name('profil.password');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');