<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id('id_wishlist');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_properti');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_properti')->references('id_properti')->on('properties')->onDelete('cascade');
            $table->unique(['id_user', 'id_properti']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
