<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Animes\Pages\ListAnimes;
use App\Filament\Resources\Characters\Pages\ListCharacters;
use App\Filament\Resources\Episodes\Pages\ListEpisodes;
use App\Filament\Resources\People\Pages\ListPeople;
use App\Filament\Resources\Seasons\Pages\ListSeasons;
use App\Filament\Resources\Studios\Pages\ListStudios;
use App\Models\Anime;
use App\Models\Character;
use App\Models\Episode;
use App\Models\Person;
use App\Models\Season;
use App\Models\Studio;
use App\Models\User;
use Filament\Actions\RestoreAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SoftDeleteUxTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_anime_list_can_restore_trashed_record(): void
    {
        $anime = Anime::factory()->create();
        $anime->delete();

        $this->assertSoftDeleted($anime);

        Livewire::test(ListAnimes::class)
            ->filterTable('trashed', true)
            ->callAction(TestAction::make(RestoreAction::class)->table($anime));

        $this->assertNotSoftDeleted($anime);
    }

    public function test_anime_list_shows_trashed_indicator(): void
    {
        $anime = Anime::factory()->create();
        $anime->delete();

        Livewire::test(ListAnimes::class)
            ->assertOk()
            ->filterTable('trashed', true)
            ->assertCanSeeTableRecords([$anime]);
    }

    public function test_character_list_can_restore_trashed_record(): void
    {
        $character = Character::factory()->create();
        $character->delete();

        $this->assertSoftDeleted($character);

        Livewire::test(ListCharacters::class)
            ->filterTable('trashed', true)
            ->callAction(TestAction::make(RestoreAction::class)->table($character));

        $this->assertNotSoftDeleted($character);
    }

    public function test_character_list_shows_trashed_indicator(): void
    {
        $character = Character::factory()->create();
        $character->delete();

        Livewire::test(ListCharacters::class)
            ->assertOk()
            ->filterTable('trashed', true)
            ->assertCanSeeTableRecords([$character]);
    }

    public function test_episode_list_can_restore_trashed_record(): void
    {
        $episode = Episode::factory()->create();
        $episode->delete();

        $this->assertSoftDeleted($episode);

        Livewire::test(ListEpisodes::class)
            ->filterTable('trashed', true)
            ->callAction(TestAction::make(RestoreAction::class)->table($episode));

        $this->assertNotSoftDeleted($episode);
    }

    public function test_episode_list_shows_trashed_indicator(): void
    {
        $episode = Episode::factory()->create();
        $episode->delete();

        Livewire::test(ListEpisodes::class)
            ->assertOk()
            ->filterTable('trashed', true)
            ->assertCanSeeTableRecords([$episode]);
    }

    public function test_person_list_can_restore_trashed_record(): void
    {
        $person = Person::factory()->create();
        $person->delete();

        $this->assertSoftDeleted($person);

        Livewire::test(ListPeople::class)
            ->filterTable('trashed', true)
            ->callAction(TestAction::make(RestoreAction::class)->table($person));

        $this->assertNotSoftDeleted($person);
    }

    public function test_person_list_shows_trashed_indicator(): void
    {
        $person = Person::factory()->create();
        $person->delete();

        Livewire::test(ListPeople::class)
            ->assertOk()
            ->filterTable('trashed', true)
            ->assertCanSeeTableRecords([$person]);
    }

    public function test_season_list_can_restore_trashed_record(): void
    {
        $season = Season::factory()->create();
        $season->delete();

        $this->assertSoftDeleted($season);

        Livewire::test(ListSeasons::class)
            ->filterTable('trashed', true)
            ->callAction(TestAction::make(RestoreAction::class)->table($season));

        $this->assertNotSoftDeleted($season);
    }

    public function test_season_list_shows_trashed_indicator(): void
    {
        $season = Season::factory()->create();
        $season->delete();

        Livewire::test(ListSeasons::class)
            ->assertOk()
            ->filterTable('trashed', true)
            ->assertCanSeeTableRecords([$season]);
    }

    public function test_studio_list_can_restore_trashed_record(): void
    {
        $studio = Studio::factory()->create();
        $studio->delete();

        $this->assertSoftDeleted($studio);

        Livewire::test(ListStudios::class)
            ->filterTable('trashed', true)
            ->callAction(TestAction::make(RestoreAction::class)->table($studio));

        $this->assertNotSoftDeleted($studio);
    }

    public function test_studio_list_shows_trashed_indicator(): void
    {
        $studio = Studio::factory()->create();
        $studio->delete();

        Livewire::test(ListStudios::class)
            ->assertOk()
            ->filterTable('trashed', true)
            ->assertCanSeeTableRecords([$studio]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($this->admin);
    }
}
