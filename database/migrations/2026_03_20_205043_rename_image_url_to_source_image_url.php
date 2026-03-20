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
        Schema::table('animes', function (Blueprint $table): void {
            $table->renameColumn('source_image_url', 'image_url');
        });

        Schema::table('characters', function (Blueprint $table): void {
            $table->renameColumn('source_image_url', 'image_url');
        });

        Schema::table('people', function (Blueprint $table): void {
            $table->renameColumn('source_image_url', 'image_url');
        });

        Schema::table('studios', function (Blueprint $table): void {
            $table->renameColumn('source_logo_url', 'logo_url');
        });
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('animes', function (Blueprint $table): void {
            $table->renameColumn('image_url', 'source_image_url');
        });

        Schema::table('characters', function (Blueprint $table): void {
            $table->renameColumn('image_url', 'source_image_url');
        });

        Schema::table('people', function (Blueprint $table): void {
            $table->renameColumn('image_url', 'source_image_url');
        });

        Schema::table('studios', function (Blueprint $table): void {
            $table->renameColumn('logo_url', 'source_logo_url');
        });
    }
};
