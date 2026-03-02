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
        Schema::table('genres', function (Blueprint $table) {
            $table->dropColumn('mal_title');
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->string('mal_title', 100)->after('id');
        });
    }
};
