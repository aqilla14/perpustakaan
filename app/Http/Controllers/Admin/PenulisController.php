<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penulis;
use Illuminate\Http\Request;

class PenulisController extends Controller
{
    public function index()
    {
        $penulisList = Penulis::withCount('bukus')
            ->orderBy('nama_penulis')
            ->paginate(10);
        return view('admin.penulis.index', compact('penulisList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penulis' => 'required|string|max:150|unique:penulis,nama_penulis',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|unique:penulis,email',
            'website' => 'nullable|url',
        ], [
            'nama_penulis.required' => 'Nama penulis wajib diisi',
            'nama_penulis.unique' => 'Nama penulis sudah terdaftar',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'website.url' => 'Format website tidak valid',
        ]);

        Penulis::create($request->all());

        return redirect()->route('admin.penulis.index')
            ->with('success', 'Penulis berhasil ditambahkan!');
    }

    public function update(Request $request, Penulis $penulis)
    {
        $request->validate([
            'nama_penulis' => 'required|string|max:150|unique:penulis,nama_penulis,' . $penulis->id,
            'bio' => 'nullable|string',
            'email' => 'nullable|email|unique:penulis,email,' . $penulis->id,
            'website' => 'nullable|url',
        ]);

        $penulis->update($request->all());

        return redirect()->route('admin.penulis.index')
            ->with('success', 'Penulis berhasil diupdate!');
    }

    public function destroy(Penulis $penulis)
    {
        // Cek apakah penulis memiliki buku
        if ($penulis->bukus()->count() > 0) {
            return redirect()->route('admin.penulis.index')
                ->with('error', 'Penulis tidak dapat dihapus karena masih memiliki ' . $penulis->bukus()->count() . ' buku!');
        }

        $penulis->delete();

        return redirect()->route('admin.penulis.index')
            ->with('success', 'Penulis berhasil dihapus!');
    }
}