<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Genres\Pages\CreateGenre;
use App\Filament\Resources\Genres\Pages\EditGenre;
use App\Filament\Resources\Genres\Pages\ListGenres;
use App\Filament\Resources\Genres\Pages\ViewGenre;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class GenreResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_can_create_genre(): void
    {
        Livewire::test(CreateGenre::class)
            ->fillForm([
                'mal_title' => 'Action',
                'name' => 'Action',
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseHas(Genre::class, [
            'mal_title' => 'Action',
            'name' => 'Action',
        ]);
    }

    public function test_can_update_genre(): void
    {
        $genre = Genre::factory()->create();

        Livewire::test(EditGenre::class, ['record' => $genre->id])
            ->fillForm([
                'name' => 'Updated Genre',
            ])
            ->call('save')
            ->assertNotified();

        $this->assertDatabaseHas(Genre::class, [
            'id' => $genre->id,
            'name' => 'Updated Genre',
        ]);
    }

    public function test_create_page_renders(): void
    {
        Livewire::test(CreateGenre::class)
            ->assertOk();
    }

    public function test_create_validates_required_fields(): void
    {
        Livewire::test(CreateGenre::class)
            ->fillForm([
                'mal_title' => null,
                'name' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'mal_title' => 'required',
                'name' => 'required',
            ])
            ->assertNotNotified();
    }

    public function test_edit_page_renders(): void
    {
        $genre = Genre::factory()->create();

        Livewire::test(EditGenre::class, ['record' => $genre->id])
            ->assertOk();
    }

    public function test_list_page_renders(): void
    {
        Genre::factory()->count(3)->create();

        Livewire::test(ListGenres::class)
            ->assertOk();
    }

    public function test_view_page_renders(): void
    {
        $genre = Genre::factory()->create();

        Livewire::test(ViewGenre::class, ['record' => $genre->id])
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }
}
