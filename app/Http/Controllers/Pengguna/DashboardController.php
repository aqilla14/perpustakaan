<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
    $pengguna = Auth::user();;

        return view('pengguna.dashboard', compact('pengguna'));
    }
}
