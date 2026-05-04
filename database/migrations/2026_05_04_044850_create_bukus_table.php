<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukusTable extends Migration
{
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->foreignId('penulis_id')->constrained('penulis')->onDelete('restrict');
            $table->string('penerbit', 150);
            $table->integer('tahun_terbit');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');
            $table->integer('stok')->default(0);
            $table->string('cover_buku')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bukus');
    }
}