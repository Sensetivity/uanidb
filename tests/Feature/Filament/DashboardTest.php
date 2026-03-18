<?php

namespace Tests\Feature\Filament;

use App\Filament\Widgets\AnimeByTypeChart;
use App\Filament\Widgets\ImportActivityChart;
use App\Filament\Widgets\RecentlyImportedAnime;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TranslationProgress;
use App\Models\Anime;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_anime_by_type_chart_renders(): void
    {
        Anime::factory()->count(2)->create();

        Livewire::test(AnimeByTypeChart::class)
            ->assertOk();
    }

    public function test_import_activity_chart_renders(): void
    {
        Livewire::test(ImportActivityChart::class)
            ->assertOk();
    }

    public function test_recently_imported_anime_renders(): void
    {
        Anime::factory()->count(5)->create();

        Livewire::test(RecentlyImportedAnime::class)
            ->assertOk();
    }

    public function test_stats_overview_renders(): void
    {
        Anime::factory()->count(3)->create();

        Livewire::test(StatsOverview::class)
            ->assertOk();
    }

    public function test_translation_progress_renders(): void
    {
        Livewire::test(TranslationProgress::class)
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }
}
