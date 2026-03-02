<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anime_titles', function (Blueprint $table) {
            $table->dropColumn('kind');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anime_titles', function (Blueprint $table) {
            $table->string('kind', 50)->nullable()->comment('Original, Romanized, English, etc.')->after('source');
        });
    }
};
