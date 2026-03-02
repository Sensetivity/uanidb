<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }

    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('commentable_id');
            $table->string('commentable_type', 50)->comment('anime, review, news');
            $table->text('content');
            $table->integer('likes_count')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index(['commentable_id', 'commentable_type']);
            $table->index('parent_id');

            $table->foreign('parent_id')
                ->references('id')
                ->on('comments')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }
};
