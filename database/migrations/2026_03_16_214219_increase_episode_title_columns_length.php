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
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('title', 255)->change();
            $table->string('title_en', 255)->nullable()->change();
            $table->string('title_ja', 255)->nullable()->change();
            $table->string('title_uk', 255)->nullable()->change();
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('title', 500)->change();
            $table->string('title_en', 500)->nullable()->change();
            $table->string('title_ja', 500)->nullable()->change();
            $table->string('title_uk', 500)->nullable()->change();
        });
    }
};
