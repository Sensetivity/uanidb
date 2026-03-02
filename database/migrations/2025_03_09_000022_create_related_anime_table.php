<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('related_anime');
    }

    public function up(): void
    {
        Schema::create('related_anime', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('related_anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('relation_type', 50)->index()->comment('sequel, prequel, side_story, spin_off, etc.');
            $table->timestamps();

            $table->unique(['anime_id', 'related_anime_id']);
            $table->index('related_anime_id');
        });
    }
};
