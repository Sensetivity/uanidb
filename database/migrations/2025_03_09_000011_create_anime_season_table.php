<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_season', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('season_id')->constrained('seasons')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('part', 50)->nullable()->comment('Part 1, Part 2, etc.');
            $table->timestamps();

            $table->unique(['anime_id', 'season_id']);
            $table->index('season_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_season');
    }
};
