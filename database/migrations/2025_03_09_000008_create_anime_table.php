<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('anime');
    }

    public function up(): void
    {
        Schema::create('anime', function (Blueprint $table) {
            $table->id();
            $table->integer('mal_id')->unique();
            $table->string('title')->index();
            $table->string('slug')->unique();
            $table->text('synopsis')->nullable();
            $table->text('synopsis_uk')->nullable();
            $table->string('type', 50)->nullable()->index()->comment('TV, OVA, Movie, Special, ONA, Music');
            $table->integer('episodes')->nullable();
            $table->string('status', 50)->nullable()->index()->comment('Airing, Finished, Not yet aired');
            $table->date('aired_from')->nullable()->index();
            $table->date('aired_to')->nullable();
            $table->boolean('aired_unknown')->default(false);
            $table->string('aired_string', 100)->nullable();
            $table->string('broadcast', 100)->nullable();
            $table->integer('source_type')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in minutes');
            $table->string('rating', 50)->nullable()->comment('G, PG, PG-13, R, R+, Rx');
            $table->float('score')->nullable()->index();
            $table->integer('rank')->nullable();
            $table->float('popularity')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }
};
