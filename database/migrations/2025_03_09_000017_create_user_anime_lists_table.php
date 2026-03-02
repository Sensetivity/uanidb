<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_anime_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('status', 20)->index()->comment('watching, completed, on_hold, dropped, plan_to_watch');
            $table->integer('episode_progress')->default(0);
            $table->integer('score')->nullable();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_private')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'anime_id']);
            $table->index('anime_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_anime_lists');
    }
};
