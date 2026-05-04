<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamen';
    
    protected $fillable = [
        'kode_peminjaman',
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'jatuh_tempo',
        'tanggal_kembali',
        'status',
        'denda',
        'keterangan',
    ];

    protected $dates = [
        'tanggal_pinjam',
        'jatuh_tempo',
        'tanggal_kembali',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function hitungDenda()
    {
        if ($this->tanggal_kembali && $this->tanggal_kembali > $this->jatuh_tempo) {
            $hariTerlambat = Carbon::parse($this->jatuh_tempo)->diffInDays(Carbon::parse($this->tanggal_kembali));
            return $hariTerlambat * 1000;
        }
        
        if ($this->status == 'dipinjam' && Carbon::now()->greaterThan($this->jatuh_tempo)) {
            $hariTerlambat = Carbon::parse($this->jatuh_tempo)->diffInDays(Carbon::now());
            return $hariTerlambat * 1000;
        }
        
        return 0;
    }

    public function isTerlambat()
    {
        if ($this->status == 'dipinjam' && Carbon::now()->greaterThan($this->jatuh_tempo)) {
            return true;
        }
        return false;
    }

    public static function generateKodePeminjaman()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $hari = date('d');
        $lastPeminjaman = self::whereDate('created_at', date('Y-m-d'))->count() + 1;
        
        return 'PJM/' . $tahun . '/' . $bulan . '/' . $hari . '/' . str_pad($lastPeminjaman, 4, '0', STR_PAD_LEFT);
    }
}