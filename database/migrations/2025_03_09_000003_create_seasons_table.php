<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('year');
            $table->string('season_of_year', 20)->comment('Winter, Spring, Summer, Fall');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false)->index();
            $table->timestamps();

            $table->index(['year', 'season_of_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};
