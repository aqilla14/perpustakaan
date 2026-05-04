<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = User::where('role', 'pengguna')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.anggota.index', compact('anggota'));
    }
    
    public function show(User $user)
    {
        $user->load('peminjamen');
        return view('admin.anggota.show', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);
        
        $user->update($request->all());
        
        return redirect()->route('admin.anggota.index')
            ->with('success', 'Data anggota berhasil diupdate!');
    }
    
    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:aktif,nonaktif,diblokir'
        ]);
        
        $user->update(['status' => $request->status]);
        
        return redirect()->back()
            ->with('success', 'Status anggota berhasil diubah menjadi ' . $request->status);
    }
    
    public function destroy(User $user)
    {
        if ($user->peminjamen()->whereIn('status', ['dipinjam', 'disetujui'])->exists()) {
            return redirect()->back()
                ->with('error', 'Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif!');
        }
        
        $user->delete();
        
        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }
}