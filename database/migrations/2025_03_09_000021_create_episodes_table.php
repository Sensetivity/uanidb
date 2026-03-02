<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('mal_id')->nullable()->index();
            $table->integer('type')->default(1)->index()->comment('1-Regular, 2-Compilation, 3-Filler');
            $table->integer('number');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('title_en')->nullable();
            $table->string('title_uk')->nullable();
            $table->string('title_ja')->nullable();
            $table->text('synopsis')->nullable();
            $table->text('synopsis_uk')->nullable();
            $table->string('aired_string', 50)->nullable();
            $table->date('aired')->nullable()->index();
            $table->boolean('aired_unknown')->default(false);
            $table->integer('duration')->nullable()->comment('Duration in minutes');
            $table->float('rating')->nullable()->comment('Episode rating');
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->unique(['anime_id', 'number']);
            $table->index('anime_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
