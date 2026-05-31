<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'nama_mitra')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('nama_mitra');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_mitra', 100)->nullable();
        });
    }
};
