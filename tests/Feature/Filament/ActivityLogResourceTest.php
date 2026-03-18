<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\ActivityLogs\Pages\ListActivityLogs;
use App\Filament\Resources\ActivityLogs\Pages\ViewActivityLog;
use App\Models\Anime;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ActivityLogResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_list_page_renders(): void
    {
        Livewire::test(ListActivityLogs::class)
            ->assertOk();
    }

    public function test_list_page_shows_activity_entries(): void
    {
        $anime = Anime::factory()->create();

        $anime->update(['title' => 'Updated Title']);

        Livewire::test(ListActivityLogs::class)
            ->assertOk()
            ->assertCanSeeTableRecords(Activity::query()->get());
    }

    public function test_view_page_renders(): void
    {
        $anime = Anime::factory()->create();

        $activity = Activity::query()->latest()->first();

        Livewire::test(ViewActivityLog::class, ['record' => $activity->id])
            ->assertOk();
    }

    public function test_view_page_shows_updated_properties(): void
    {
        $anime = Anime::factory()->create();

        $anime->update(['title' => 'Changed Title']);

        $activity = Activity::query()->where('event', 'updated')->latest()->first();

        Livewire::test(ViewActivityLog::class, ['record' => $activity->id])
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }
}
