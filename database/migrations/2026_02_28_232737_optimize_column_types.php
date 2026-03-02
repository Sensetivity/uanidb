<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate animes.rating from MAL string to AnimeRatingEnum int value
        DB::statement("
            UPDATE animes SET rating = CASE
                WHEN rating = 'G - All Ages' THEN '1'
                WHEN rating = 'PG - Children' THEN '2'
                WHEN rating = 'PG-13 - Teens 13 or older' THEN '3'
                WHEN rating = 'R - 17+ (violence & profanity)' THEN '4'
                WHEN rating = 'R+ - Mild Nudity' THEN '5'
                WHEN rating = 'Rx - Hentai' THEN '6'
                ELSE NULL
            END
            WHERE rating IS NOT NULL
        ");

        Schema::table('animes', function (Blueprint $table) {
            $table->unsignedInteger('mal_id')->nullable(false)->change();
            $table->unsignedTinyInteger('source_type')->nullable()->change();
            $table->unsignedTinyInteger('rating')->nullable()->comment('AnimeRatingEnum')->change();
            $table->float('score')->nullable()->change();
            $table->float('popularity')->nullable()->change();
        });

        Schema::table('user_anime_lists', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')->nullable(false)->comment('WatchlistStatusEnum')->change();
        });

        Schema::table('seasons', function (Blueprint $table) {
            $table->unsignedTinyInteger('season_of_year')->nullable(false)->comment('SeasonOfYearEnum')->change();
        });

        Schema::table('promotion_videos', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')->nullable()->comment('PromotionVideoTypeEnum')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animes', function (Blueprint $table) {
            $table->integer('mal_id')->nullable(false)->change();
            $table->integer('source_type')->nullable()->change();
            $table->string('rating', 50)->nullable()->comment('G, PG, PG-13, R, R+, Rx')->change();
            $table->double('score')->nullable()->change();
            $table->double('popularity')->nullable()->change();
        });

        Schema::table('user_anime_lists', function (Blueprint $table) {
            $table->string('status', 20)->nullable(false)->comment('watching, completed, on_hold, dropped, plan_to_watch')->change();
        });

        Schema::table('seasons', function (Blueprint $table) {
            $table->string('season_of_year', 20)->nullable(false)->comment('Winter, Spring, Summer, Fall')->change();
        });

        Schema::table('promotion_videos', function (Blueprint $table) {
            $table->string('type', 50)->nullable()->comment('Trailer, PV, Character, Opening, Ending')->change();
        });
    }
};
