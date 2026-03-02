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
        Schema::table('anime', function (Blueprint $table) {
            $table->string('type', 50)->change();
            $table->string('status', 50)->change();
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anime', function (Blueprint $table) {
            $table->tinyInteger('type')->change();
            $table->tinyInteger('status')->change();
        });
    }
};
