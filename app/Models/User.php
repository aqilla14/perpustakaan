<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
        'no_anggota',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function peminjamen()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAnggota()
    {
        return $this->role === 'anggota';
    }
}