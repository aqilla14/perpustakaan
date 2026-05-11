<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('pengguna.profil.index', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);
        
        $user->update($request->only(['nama_lengkap', 'email', 'no_telepon', 'alamat']));
        
        return redirect()->back()->with('success', 'Profil berhasil diupdate!');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user = auth()->user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini salah!');
        }
        
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}