<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('anime_studio');
    }

    public function up(): void
    {
        Schema::create('anime_studio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('studio_id')->constrained('studios')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('role', 100)->nullable();
            $table->boolean('is_main')->default(false)->index();
            $table->integer('order')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('anime_id');
            $table->index('studio_id');
        });
    }
};
