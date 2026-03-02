<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('character_voice');
    }

    public function up(): void
    {
        Schema::create('character_voice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained('characters')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('language', 10)->default('ja')->index();
            $table->timestamps();

            $table->unique(['character_id', 'person_id', 'anime_id', 'language']);
            $table->index('person_id');
            $table->index('anime_id');
        });
    }
};
