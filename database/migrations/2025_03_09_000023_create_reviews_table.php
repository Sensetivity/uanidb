<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }

    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('reviewable_id');
            $table->string('reviewable_type', 50)->comment('anime, character, person');
            $table->string('title')->nullable();
            $table->text('content');
            $table->integer('score')->nullable();
            $table->boolean('is_spoiler')->default(false);
            $table->integer('likes_count')->default(0);
            $table->timestamps();

            $table->index('user_id');
            $table->index(['reviewable_id', 'reviewable_type']);
        });
    }
};
