<?php

namespace Tests\Feature\Filament;

use App\Enums\ImportJobTypeEnum;
use App\Enums\ImportStatusEnum;
use App\Filament\Resources\ImportLogs\Pages\ListImportLogs;
use App\Filament\Resources\ImportLogs\Pages\ViewImportLog;
use App\Models\Anime;
use App\Models\ImportLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ImportLogResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_list_page_can_filter_by_job_type(): void
    {
        $importAnimeLog = ImportLog::factory()->create([
            'job_type' => ImportJobTypeEnum::ImportAnime,
        ]);
        $translateLog = ImportLog::factory()->create([
            'job_type' => ImportJobTypeEnum::TranslateAnime,
        ]);

        Livewire::test(ListImportLogs::class)
            ->assertCanSeeTableRecords([$importAnimeLog, $translateLog])
            ->filterTable('job_type', ImportJobTypeEnum::ImportAnime->value)
            ->assertCanSeeTableRecords([$importAnimeLog])
            ->assertCanNotSeeTableRecords([$translateLog]);
    }

    public function test_list_page_can_filter_by_status(): void
    {
        $completedLog = ImportLog::factory()->completed()->create();
        $failedLog = ImportLog::factory()->failed()->create();

        Livewire::test(ListImportLogs::class)
            ->assertCanSeeTableRecords([$completedLog, $failedLog])
            ->filterTable('status', ImportStatusEnum::Completed->value)
            ->assertCanSeeTableRecords([$completedLog])
            ->assertCanNotSeeTableRecords([$failedLog]);
    }

    public function test_list_page_renders(): void
    {
        Livewire::test(ListImportLogs::class)
            ->assertOk();
    }

    public function test_list_page_shows_import_log_entries(): void
    {
        $logs = ImportLog::factory()->count(3)->create();

        Livewire::test(ListImportLogs::class)
            ->assertOk()
            ->assertCanSeeTableRecords($logs);
    }

    public function test_view_page_renders(): void
    {
        $importLog = ImportLog::factory()->completed()->create();

        Livewire::test(ViewImportLog::class, ['record' => $importLog->id])
            ->assertOk();
    }

    public function test_view_page_renders_failed_log_with_error(): void
    {
        $importLog = ImportLog::factory()->failed()->create([
            'error_message' => 'API connection timeout',
        ]);

        Livewire::test(ViewImportLog::class, ['record' => $importLog->id])
            ->assertOk();
    }

    public function test_view_page_renders_with_anime(): void
    {
        $anime = Anime::factory()->create();

        $importLog = ImportLog::factory()->completed()->create([
            'anime_id' => $anime->id,
            'mal_id' => $anime->mal_id,
            'job_type' => ImportJobTypeEnum::ImportAnime,
        ]);

        Livewire::test(ViewImportLog::class, ['record' => $importLog->id])
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }
}
