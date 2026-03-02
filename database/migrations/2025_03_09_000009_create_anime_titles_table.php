<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_titles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->string('language', 10)->index();
            $table->boolean('is_main')->default(false)->index();
            $table->string('type', 50)->nullable()->comment('Original, Romanized, English, etc.');
            $table->timestamps();

            $table->index('anime_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_titles');
    }
};
