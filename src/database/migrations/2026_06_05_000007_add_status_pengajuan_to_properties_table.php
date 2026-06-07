<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (! Schema::hasColumn('properties', 'status_pengajuan')) {
                $table->enum('status_pengajuan', ['pending', 'approved', 'rejected'])->default('pending')->after('fasilitas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'status_pengajuan')) {
                $table->dropColumn('status_pengajuan');
            }
        });
    }
};
