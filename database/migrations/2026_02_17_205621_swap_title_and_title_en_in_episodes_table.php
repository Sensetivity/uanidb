<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration
{
    /**
     * Reverse: swap back.
     */
    public function down(): void
    {
        DB::table('episodes')->orderBy('id')->chunkById(500, function ($episodes) {
            foreach ($episodes as $episode) {
                DB::table('episodes')->where('id', $episode->id)->update([
                    'title' => $episode->title_en,
                    'title_en' => $episode->title_en !== $episode->title ? $episode->title : null,
                ]);
            }
        });
    }

    /**
     * Swap title (English) and title_en (Romaji) — they were mapped incorrectly.
     * After: title = Romaji (fallback to English), title_en = English.
     */
    public function up(): void
    {
        DB::table('episodes')->orderBy('id')->chunkById(500, function ($episodes) {
            foreach ($episodes as $episode) {
                DB::table('episodes')->where('id', $episode->id)->update([
                    'title' => $episode->title_en ?? $episode->title,
                    'title_en' => $episode->title,
                ]);
            }
        });
    }
};
