<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration
{
    public function down(): void {}

    public function up(): void
    {
        DB::statement("UPDATE episodes SET title = TRIM(REPLACE(title, '\u{00A0}', ' '))");
        DB::statement("UPDATE episodes SET title_en = TRIM(REPLACE(title_en, '\u{00A0}', ' ')) WHERE title_en IS NOT NULL");
        DB::statement("UPDATE episodes SET title_ja = TRIM(REPLACE(title_ja, '\u{00A0}', ' ')) WHERE title_ja IS NOT NULL");
    }
};
