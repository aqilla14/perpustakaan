<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    use HasFactory;

    protected $table = 'penulis';
    
    protected $fillable = [
        'nama_penulis',
        'bio',
        'email',
        'website',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}