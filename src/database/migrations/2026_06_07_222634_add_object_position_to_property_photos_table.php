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
        Schema::table('property_photos', function (Blueprint $table) {
            $table->string('object_position', 20)->nullable()->default('50');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_photos', function (Blueprint $table) {
            $table->dropColumn('object_position');
        });
    }
};
