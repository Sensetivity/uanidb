<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::table('anime_titles', function (Blueprint $table) {
            $table->dropUnique('anime_titles_anime_id_title_unique');
            $table->dropIndex('anime_titles_anime_id_language_index');
            $table->index('anime_id', 'anime_titles_anime_id_index');
            $table->index('language', 'anime_titles_language_index');
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove duplicate rows, keeping the one with the lowest id
        // Uses subquery syntax compatible with both MySQL and SQLite
        DB::statement('
            DELETE FROM anime_titles
            WHERE id NOT IN (
                SELECT min_id FROM (
                    SELECT MIN(id) AS min_id
                    FROM anime_titles
                    GROUP BY anime_id, title
                ) AS keep
            )
        ');

        Schema::table('anime_titles', function (Blueprint $table) {
            // Add composite index first — MySQL requires anime_id to remain indexed (FK constraint)
            $table->index(['anime_id', 'language'], 'anime_titles_anime_id_language_index');

            // Prevent the same title text from being inserted twice for the same anime
            $table->unique(['anime_id', 'title'], 'anime_titles_anime_id_title_unique');
        });

        Schema::table('anime_titles', function (Blueprint $table) {
            // Now safe to drop: composite index above covers anime_id for the FK
            $table->dropIndex('anime_titles_anime_id_index');
            $table->dropIndex('anime_titles_language_index');
        });
    }
};
