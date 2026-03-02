<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('people');
    }

    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->integer('mal_id')->nullable()->index();
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->string('japanese_name')->nullable();
            $table->text('about')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }
};
