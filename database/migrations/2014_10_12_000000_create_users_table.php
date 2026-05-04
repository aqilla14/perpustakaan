<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_anggota')->unique();
            $table->date('tgl_daftar')->default(now());
            $table->enum('status', ['aktif', 'nonaktif', 'diblokir'])->default('aktif');
            $table->enum('role', ['admin', 'pengguna'])->default('pengguna');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}