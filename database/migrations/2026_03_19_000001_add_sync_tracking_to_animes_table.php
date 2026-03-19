<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function down(): void
    {
        Schema::table('animes', function (Blueprint $table) {
            $table->dropIndex('animes_deleted_at_sync_priority_index');
            $table->dropColumn(['last_synced_at', 'sync_priority', 'failed_sync_count']);
        });
    }

    public function up(): void
    {
        Schema::table('animes', function (Blueprint $table) {
            $table->timestamp('last_synced_at')->nullable()->after('image_url');
            $table->float('sync_priority')->default(0.0)->after('last_synced_at');
            $table->unsignedTinyInteger('failed_sync_count')->default(0)->after('sync_priority');

            $table->index(['deleted_at', 'sync_priority'], 'animes_deleted_at_sync_priority_index');
        });
    }
};
