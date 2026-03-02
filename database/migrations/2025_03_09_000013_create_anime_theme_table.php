<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('anime_theme');
    }

    public function up(): void
    {
        Schema::create('anime_theme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('theme_id')->constrained('themes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();

            $table->unique(['anime_id', 'theme_id']);
            $table->index('theme_id');
        });
    }
};
