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
        Schema::table('themes', function (Blueprint $table) {});
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn(['title', 'title_uk']);
        });

        Schema::table('themes', function (Blueprint $table) {
            $table->string('name', 100)->after('id');
            $table->smallInteger('type')->change();
        });
    }
};
