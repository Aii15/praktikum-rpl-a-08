<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // NOTE: Changing column length may require the doctrine/dbal package
            // and may not be supported on all sqlite setups. If this fails,
            // run a fresh migration or install doctrine/dbal.
            if (Schema::hasColumn('users', 'nama_mitra')) {
                $table->string('nama_mitra', 100)->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nama_mitra')) {
                $table->string('nama_mitra', 255)->nullable()->change();
            }
        });
    }
};
