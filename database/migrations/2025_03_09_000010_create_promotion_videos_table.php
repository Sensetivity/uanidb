<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title')->nullable();
            $table->string('video_url');
            $table->string('video_id', 100)->nullable();
            $table->string('type', 50)->nullable()->comment('Trailer, PV, Character, Opening, Ending');
            $table->date('published_at')->nullable();
            $table->string('language', 10)->nullable();
            $table->text('description')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in seconds');
            $table->boolean('is_main')->default(false)->index();
            $table->integer('order')->default(0)->index();
            $table->timestamps();

            $table->index('anime_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_videos');
    }
};
