<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id('id_properti');
            $table->unsignedBigInteger('id_mitra');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_lokasi');
            $table->string('nama_properti', 150);
            $table->text('deskripsi');
            $table->decimal('harga_per_periode', 12, 2);
            $table->text('fasilitas')->nullable();
            $table->timestamps();

            $table->foreign('id_mitra')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('property_categories')->onDelete('restrict');
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
