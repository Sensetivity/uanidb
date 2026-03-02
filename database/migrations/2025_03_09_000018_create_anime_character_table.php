<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('anime_character');
    }

    public function up(): void
    {
        Schema::create('anime_character', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('character_id')->constrained('characters')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('role', 50)->nullable()->index()->comment('Main, Supporting, Background');
            $table->timestamps();

            $table->index('anime_id');
            $table->index('character_id');
        });
    }
};
