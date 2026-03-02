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
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropIndex('seasons_year_season_of_year_index');
            $table->unique(['year', 'season_of_year'], 'seasons_year_season_of_year_unique');
        });
    }

    public function down(): void
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropUnique('seasons_year_season_of_year_unique');
            $table->index(['year', 'season_of_year'], 'seasons_year_season_of_year_index');
        });
    }
};
