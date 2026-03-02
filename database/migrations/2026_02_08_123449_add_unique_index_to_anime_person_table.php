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
        Schema::table('anime_person', function (Blueprint $table) {
            $table->unique(['anime_id', 'person_id', 'role'], 'anime_person_anime_id_person_id_role_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anime_person', function (Blueprint $table) {
            $table->dropUnique('anime_person_anime_id_person_id_role_unique');
        });
    }
};
