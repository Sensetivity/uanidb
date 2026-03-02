<?php

use App\Enums\AnimeTitleTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anime_titles', function (Blueprint $table): void {
            $table->renameColumn('type', 'kind');
            $table->unsignedTinyInteger('source')
                ->default(AnimeTitleTypeEnum::Jikan->value)
                ->after('is_main');
        });

        Schema::table('animes', function (Blueprint $table): void {
            $table->unsignedInteger('anidb_id')->nullable()->unique()->after('mal_id');
        });
    }

    public function down(): void
    {
        Schema::table('animes', function (Blueprint $table): void {
            $table->dropColumn('anidb_id');
        });

        Schema::table('anime_titles', function (Blueprint $table): void {
            $table->dropColumn('source');
            $table->renameColumn('kind', 'type');
        });
    }
};
