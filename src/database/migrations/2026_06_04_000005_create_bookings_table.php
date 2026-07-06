<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('id_booking');
            $table->unsignedBigInteger('id_properti');
            $table->unsignedBigInteger('id_user');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('status_booking', 20)->default('pending');
            $table->timestamps();

            $table->foreign('id_properti')->references('id_properti')->on('properties')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
