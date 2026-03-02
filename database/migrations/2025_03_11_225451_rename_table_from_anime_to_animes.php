<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animes', function (Blueprint $table) {
            $table->rename('anime');
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anime', function (Blueprint $table) {
            $table->rename('animes');
        });
    }
};
