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
        Schema::table('anime_licensor', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anime_licensor', function (Blueprint $table) {
            $table->integer('order')->after('studio_id')->nullable()->default(0);
        });
    }
};
