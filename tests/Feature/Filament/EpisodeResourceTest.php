<?php

namespace Tests\Feature\Filament;

use App\Enums\EpisodeTypeEnum;
use App\Filament\Resources\Episodes\Pages\CreateEpisode;
use App\Filament\Resources\Episodes\Pages\EditEpisode;
use App\Filament\Resources\Episodes\Pages\ListEpisodes;
use App\Filament\Resources\Episodes\Pages\ViewEpisode;
use App\Models\Anime;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EpisodeResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_can_create_episode(): void
    {
        $anime = Anime::factory()->create();

        Livewire::test(CreateEpisode::class)
            ->fillForm([
                'anime_id' => $anime->id,
                'number' => 1,
                'type' => EpisodeTypeEnum::Regular->value,
                'title' => 'Episode 1',
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseHas(Episode::class, [
            'anime_id' => $anime->id,
            'number' => 1,
            'type' => EpisodeTypeEnum::Regular->value,
            'title' => 'Episode 1',
        ]);
    }

    public function test_can_update_episode(): void
    {
        $episode = Episode::factory()->create();

        Livewire::test(EditEpisode::class, ['record' => $episode->id])
            ->fillForm([
                'title' => 'Updated Title',
            ])
            ->call('save')
            ->assertNotified();

        $this->assertDatabaseHas(Episode::class, [
            'id' => $episode->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_create_page_renders(): void
    {
        Livewire::test(CreateEpisode::class)
            ->assertOk();
    }

    public function test_create_validates_required_fields(): void
    {
        Livewire::test(CreateEpisode::class)
            ->fillForm([
                'anime_id' => null,
                'number' => null,
                'type' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'anime_id' => 'required',
                'number' => 'required',
                'type' => 'required',
            ])
            ->assertNotNotified();
    }

    public function test_edit_page_renders(): void
    {
        $episode = Episode::factory()->create();

        Livewire::test(EditEpisode::class, ['record' => $episode->id])
            ->assertOk();
    }

    public function test_list_page_renders(): void
    {
        Episode::factory()->count(3)->create();

        Livewire::test(ListEpisodes::class)
            ->assertOk();
    }

    public function test_view_page_renders(): void
    {
        $episode = Episode::factory()->create();

        Livewire::test(ViewEpisode::class, ['record' => $episode->id])
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }
}
