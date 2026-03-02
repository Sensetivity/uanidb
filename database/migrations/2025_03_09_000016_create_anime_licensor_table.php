<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('anime_licensor');
    }

    public function up(): void
    {
        Schema::create('anime_licensor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('studio_id')->constrained('studios')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('region', 100)->nullable()->index();
            $table->timestamps();

            $table->index('anime_id');
            $table->index('studio_id');
        });
    }
};
