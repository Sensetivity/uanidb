<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('anime_external_links');
    }

    public function up(): void
    {
        Schema::create('anime_external_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('url');
            $table->timestamps();

            $table->index('anime_id');
        });
    }
};
