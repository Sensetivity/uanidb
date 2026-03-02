<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::table('anime_character', function (Blueprint $table) {
            $table->index('anime_id', 'anime_character_anime_id_index');
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anime_character', function (Blueprint $table) {
            // Redundant: (anime_id, character_id) UNIQUE and (anime_id, role) both serve as prefix indexes
            $table->dropIndex('anime_character_anime_id_index');
        });
    }
};
