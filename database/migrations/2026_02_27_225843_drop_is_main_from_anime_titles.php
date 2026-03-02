<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anime_titles', function (Blueprint $table) {
            $table->dropIndex(['is_main']);
            $table->dropColumn('is_main');
        });
    }

    public function down(): void
    {
        Schema::table('anime_titles', function (Blueprint $table) {
            $table->boolean('is_main')->default(false)->index()->after('language');
        });
    }
};
