<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration
{
    public function down(): void
    {
        // Romaji titles are now stored in animes.title — no rollback possible
    }

    public function up(): void
    {
        DB::table('anime_titles')->where('kind', 'Romaji')->delete();
    }
};
