<?php

namespace Tests\Feature\Filament;

use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Filament\Resources\Animes\Pages\CreateAnime;
use App\Filament\Resources\Animes\Pages\EditAnime;
use App\Filament\Resources\Animes\Pages\ListAnimes;
use App\Filament\Resources\Animes\Pages\ViewAnime;
use App\Models\Anime;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AnimeResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_can_create_anime(): void
    {
        Livewire::test(CreateAnime::class)
            ->fillForm([
                'mal_id' => 12345,
                'title' => 'Test Anime',
                'type' => AnimeTypeEnum::TV->value,
                'status' => AnimeStatusEnum::AIRING->value,
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseHas(Anime::class, [
            'mal_id' => 12345,
            'title' => 'Test Anime',
            'type' => AnimeTypeEnum::TV->value,
            'status' => AnimeStatusEnum::AIRING->value,
        ]);
    }

    public function test_can_update_anime(): void
    {
        $anime = Anime::factory()->create();

        Livewire::test(EditAnime::class, ['record' => $anime->id])
            ->fillForm([
                'title' => 'Updated Anime Title',
            ])
            ->call('save')
            ->assertNotified();

        $this->assertDatabaseHas(Anime::class, [
            'id' => $anime->id,
            'title' => 'Updated Anime Title',
        ]);
    }

    public function test_create_page_renders(): void
    {
        Livewire::test(CreateAnime::class)
            ->assertOk();
    }

    public function test_create_validates_required_fields(): void
    {
        Livewire::test(CreateAnime::class)
            ->fillForm([
                'mal_id' => null,
                'title' => null,
                'type' => null,
                'status' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'mal_id' => 'required',
                'title' => 'required',
                'type' => 'required',
                'status' => 'required',
            ])
            ->assertNotNotified();
    }

    public function test_edit_page_renders(): void
    {
        $anime = Anime::factory()->create();

        Livewire::test(EditAnime::class, ['record' => $anime->id])
            ->assertOk();
    }

    public function test_list_page_renders(): void
    {
        Anime::factory()->count(3)->create();

        Livewire::test(ListAnimes::class)
            ->assertOk();
    }

    public function test_view_page_renders(): void
    {
        $anime = Anime::factory()->create();

        Livewire::test(ViewAnime::class, ['record' => $anime->id])
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }
}
