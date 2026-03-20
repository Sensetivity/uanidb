<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anime_studio', function (Blueprint $table): void {
            $table->dropUnique(['anime_id', 'studio_id']);
        });

        Schema::table('anime_producer', function (Blueprint $table): void {
            $table->dropUnique(['anime_id', 'studio_id']);
        });

        Schema::table('anime_licensor', function (Blueprint $table): void {
            $table->dropUnique(['anime_id', 'studio_id']);
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anime_studio', function (Blueprint $table): void {
            $table->unique(['anime_id', 'studio_id']);
        });

        Schema::table('anime_producer', function (Blueprint $table): void {
            $table->unique(['anime_id', 'studio_id']);
        });

        Schema::table('anime_licensor', function (Blueprint $table): void {
            $table->unique(['anime_id', 'studio_id']);
        });
    }
};
