<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_photos', function (Blueprint $table) {
            $table->id('id_foto');
            $table->unsignedBigInteger('id_properti');
            $table->string('url_foto', 255);
            $table->integer('urutan');
            $table->boolean('is_cover')->default(false);
            $table->timestamps();

            $table->foreign('id_properti')->references('id_properti')->on('properties')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_photos');
    }
};
