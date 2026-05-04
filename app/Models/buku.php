<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';
    
    protected $fillable = [
        'judul',
        'penulis_id',
        'penerbit',
        'tahun_terbit',
        'kategori_id',
        'stok',
        'cover_buku',
    ];

    public function penulis()
    {
        return $this->belongsTo(Penulis::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjamen()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function isTersedia()
    {
        return $this->stok > 0;
    }

    public function kurangiStok($jumlah = 1)
    {
        if ($this->stok >= $jumlah) {
            $this->stok -= $jumlah;
            $this->save();
            return true;
        }
        return false;
    }

    public function tambahStok($jumlah = 1)
    {
        $this->stok += $jumlah;
        $this->save();
    }
}