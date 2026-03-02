<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::table('anime_character', function (Blueprint $table) {
            $table->dropUnique('anime_character_anime_id_character_id_unique');
            $table->dropIndex('anime_character_anime_id_role_index');
            $table->index('role', 'anime_character_role_index');
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anime_character', function (Blueprint $table) {
            // Replace standalone role index with composite for wherePivot('role', ...)
            $table->dropIndex('anime_character_role_index');
            $table->index(['anime_id', 'role'], 'anime_character_anime_id_role_index');

            // Prevent the same character from being linked to the same anime twice
            $table->unique(['anime_id', 'character_id'], 'anime_character_anime_id_character_id_unique');
        });
    }
};
