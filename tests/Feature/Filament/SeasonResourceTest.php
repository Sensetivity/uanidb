<?php

namespace Tests\Feature\Filament;

use App\Enums\SeasonOfYearEnum;
use App\Filament\Resources\Seasons\Pages\CreateSeason;
use App\Filament\Resources\Seasons\Pages\EditSeason;
use App\Filament\Resources\Seasons\Pages\ListSeasons;
use App\Filament\Resources\Seasons\Pages\ViewSeason;
use App\Models\Season;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SeasonResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_can_create_season(): void
    {
        Livewire::test(CreateSeason::class)
            ->fillForm([
                'name' => 'Winter 2026',
                'year' => 2026,
                'season_of_year' => SeasonOfYearEnum::Winter->value,
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseHas(Season::class, [
            'name' => 'Winter 2026',
            'year' => 2026,
            'season_of_year' => SeasonOfYearEnum::Winter->value,
        ]);
    }

    public function test_can_update_season(): void
    {
        $season = Season::factory()->create();

        Livewire::test(EditSeason::class, ['record' => $season->id])
            ->fillForm([
                'name' => 'Updated Season',
            ])
            ->call('save')
            ->assertNotified();

        $this->assertDatabaseHas(Season::class, [
            'id' => $season->id,
            'name' => 'Updated Season',
        ]);
    }

    public function test_create_page_renders(): void
    {
        Livewire::test(CreateSeason::class)
            ->assertOk();
    }

    public function test_create_validates_required_fields(): void
    {
        Livewire::test(CreateSeason::class)
            ->fillForm([
                'name' => null,
                'year' => null,
                'season_of_year' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'name' => 'required',
                'year' => 'required',
                'season_of_year' => 'required',
            ])
            ->assertNotNotified();
    }

    public function test_edit_page_renders(): void
    {
        $season = Season::factory()->create();

        Livewire::test(EditSeason::class, ['record' => $season->id])
            ->assertOk();
    }

    public function test_list_page_renders(): void
    {
        Season::factory()->count(3)->create();

        Livewire::test(ListSeasons::class)
            ->assertOk();
    }

    public function test_view_page_renders(): void
    {
        $season = Season::factory()->create();

        Livewire::test(ViewSeason::class, ['record' => $season->id])
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($this->admin);
    }
}
