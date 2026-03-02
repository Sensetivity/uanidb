<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropUnique('themes_name_unique');
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->unique('name', 'themes_name_unique');
        });
    }
};
