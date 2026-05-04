<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Penulis;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with(['penulis', 'kategori'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        $penulisList = Penulis::all();
        $kategoris = Kategori::all();
        return view('admin.buku.create', compact('penulisList', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'penulis_id' => 'required|exists:penulis,id',
            'penerbit' => 'required|string|max:150',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'cover_buku' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required' => 'Judul buku wajib diisi',
            'penulis_id.required' => 'Penulis buku wajib dipilih',
            'penerbit.required' => 'Penerbit wajib diisi',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi',
            'stok.required' => 'Stok buku wajib diisi',
            'stok.min' => 'Stok tidak boleh kurang dari 0',
            'cover_buku.image' => 'File harus berupa gambar',
            'cover_buku.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $data = $request->except('cover_buku');

        if ($request->hasFile('cover_buku')) {
            $coverBuku = $request->file('cover_buku');
            $namaGambar = time() . '_' . $coverBuku->getClientOriginalName();
            $coverBuku->storeAs('public/covers', $namaGambar);
            $data['cover_buku'] = 'storage/covers/' . $namaGambar;
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Buku $buku)
    {
        $buku->load(['penulis', 'kategori']);
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $penulisList = Penulis::all();
        $kategoris = Kategori::all();
        return view('admin.buku.edit', compact('buku', 'penulisList', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'penulis_id' => 'required|exists:penulis,id',
            'penerbit' => 'required|string|max:150',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'cover_buku' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('cover_buku');

        if ($request->hasFile('cover_buku')) {
            // Hapus cover lama
            if ($buku->cover_buku && file_exists(public_path($buku->cover_buku))) {
                unlink(public_path($buku->cover_buku));
            }
            
            $coverBuku = $request->file('cover_buku');
            $namaGambar = time() . '_' . $coverBuku->getClientOriginalName();
            $coverBuku->storeAs('public/covers', $namaGambar);
            $data['cover_buku'] = 'storage/covers/' . $namaGambar;
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(Buku $buku)
    {
        // Hapus cover buku
        if ($buku->cover_buku && file_exists(public_path($buku->cover_buku))) {
            unlink(public_path($buku->cover_buku));
        }
        
        // Cek apakah buku sedang dipinjam
        $sedangDipinjam = $buku->peminjamen()->whereIn('status', ['dipinjam', 'disetujui'])->exists();
        
        if ($sedangDipinjam) {
            return redirect()->route('admin.buku.index')
                ->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam!');
        }
        
        $buku->delete();

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}