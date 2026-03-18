<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Animes\Pages\CreateAnime;
use App\Filament\Resources\Animes\Pages\EditAnime;
use App\Filament\Resources\Animes\Pages\ViewAnime;
use App\Filament\Resources\Characters\Pages\CreateCharacter;
use App\Filament\Resources\Characters\Pages\EditCharacter;
use App\Filament\Resources\People\Pages\CreatePerson;
use App\Filament\Resources\People\Pages\EditPerson;
use App\Models\Anime;
use App\Models\Character;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MediaManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_anime_create_form_has_poster_upload_field(): void
    {
        Livewire::test(CreateAnime::class)
            ->assertOk()
            ->assertFormFieldExists('main_poster_upload');
    }

    public function test_anime_edit_form_has_poster_upload_field(): void
    {
        $anime = Anime::factory()->create();

        Livewire::test(EditAnime::class, ['record' => $anime->id])
            ->assertOk()
            ->assertFormFieldExists('main_poster_upload');
    }

    public function test_anime_has_media_collections_registered(): void
    {
        $anime = Anime::factory()->create();

        $collections = $anime->getRegisteredMediaCollections();
        $collectionNames = $collections->pluck('name')->toArray();

        $this->assertContains('main_poster', $collectionNames);
        $this->assertContains('posters', $collectionNames);
        $this->assertContains('screenshots', $collectionNames);
    }

    public function test_anime_has_media_conversions_registered(): void
    {
        $anime = Anime::factory()->create();
        $anime->registerAllMediaConversions();

        $conversionNames = collect($anime->mediaConversions)->map(fn ($c) => $c->getName())->toArray();

        $this->assertContains('thumbnail', $conversionNames);
        $this->assertContains('medium', $conversionNames);
    }

    public function test_anime_main_poster_collection_is_single_file(): void
    {
        $anime = Anime::factory()->create();

        $collections = $anime->getRegisteredMediaCollections();
        $mainPoster = $collections->firstWhere('name', 'main_poster');

        $this->assertTrue($mainPoster->singleFile);
    }

    public function test_anime_poster_url_falls_back_to_image_url(): void
    {
        $anime = Anime::factory()->create([
            'image_url' => 'https://example.com/poster.jpg',
        ]);

        $this->assertEquals('https://example.com/poster.jpg', $anime->poster_url);
    }

    public function test_anime_poster_url_returns_null_when_no_image(): void
    {
        $anime = Anime::factory()->create([
            'image_url' => null,
        ]);

        $this->assertNull($anime->poster_url);
    }

    public function test_anime_view_page_shows_media_section(): void
    {
        $anime = Anime::factory()->create();

        Livewire::test(ViewAnime::class, ['record' => $anime->id])
            ->assertOk()
            ->assertSee('Медіа');
    }

    public function test_character_create_form_has_image_upload_field(): void
    {
        Livewire::test(CreateCharacter::class)
            ->assertOk()
            ->assertFormFieldExists('main_image_upload');
    }

    public function test_character_edit_form_has_image_upload_field(): void
    {
        $character = Character::factory()->create();

        Livewire::test(EditCharacter::class, ['record' => $character->id])
            ->assertOk()
            ->assertFormFieldExists('main_image_upload');
    }

    public function test_character_has_media_collection_registered(): void
    {
        $character = Character::factory()->create();

        $collections = $character->getRegisteredMediaCollections();
        $collectionNames = $collections->pluck('name')->toArray();

        $this->assertContains('main_image', $collectionNames);
    }

    public function test_person_create_form_has_image_upload_field(): void
    {
        Livewire::test(CreatePerson::class)
            ->assertOk()
            ->assertFormFieldExists('main_image_upload');
    }

    public function test_person_edit_form_has_image_upload_field(): void
    {
        $person = Person::factory()->create();

        Livewire::test(EditPerson::class, ['record' => $person->id])
            ->assertOk()
            ->assertFormFieldExists('main_image_upload');
    }

    public function test_person_has_media_collection_registered(): void
    {
        $person = Person::factory()->create();

        $collections = $person->getRegisteredMediaCollections();
        $collectionNames = $collections->pluck('name')->toArray();

        $this->assertContains('main_image', $collectionNames);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($this->admin);
    }
}
