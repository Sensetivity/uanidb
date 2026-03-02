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
        Schema::table('reviews', function (Blueprint $table) {
            // Drop the existing index with wrong column order
            $table->dropIndex('reviews_reviewable_id_reviewable_type_index');

            // One review per user per reviewable entity; also fixes column order
            $table->unique(
                ['reviewable_type', 'reviewable_id', 'user_id'],
                'reviews_reviewable_type_reviewable_id_user_id_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropUnique('reviews_reviewable_type_reviewable_id_user_id_unique');
            $table->index(['reviewable_id', 'reviewable_type'], 'reviews_reviewable_id_reviewable_type_index');
        });
    }
};
