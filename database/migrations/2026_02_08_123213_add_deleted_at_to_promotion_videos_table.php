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
        Schema::table('promotion_videos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('promotion_videos', function (Blueprint $table) {
            $table->softDeletes()->after('id');
        });
    }
};
