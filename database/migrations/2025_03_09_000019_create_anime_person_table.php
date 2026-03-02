<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists('anime_person');
    }

    public function up(): void
    {
        Schema::create('anime_person', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('anime')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('role', 100)->index()->comment('Director, Animator, Producer, etc.');
            $table->timestamps();

            $table->index('anime_id');
            $table->index('person_id');
        });
    }
};
