<?php

namespace Tests\Feature\Filament;

use App\Enums\CharacterRoleEnum;
use App\Filament\Resources\Characters\Pages\CreateCharacter;
use App\Filament\Resources\Characters\Pages\EditCharacter;
use App\Filament\Resources\Characters\Pages\ListCharacters;
use App\Filament\Resources\Characters\Pages\ViewCharacter;
use App\Filament\Resources\Characters\RelationManagers\AnimesRelationManager;
use App\Filament\Resources\Characters\RelationManagers\VoiceActorsRelationManager;
use App\Models\Anime;
use App\Models\Character;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CharacterResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_animes_relation_manager_lists_related_animes(): void
    {
        $character = Character::factory()->create();
        $animes = Anime::factory()->count(3)->create();

        $character->animes()->attach($animes->pluck('id'), ['role' => CharacterRoleEnum::Main->value]);

        Livewire::test(AnimesRelationManager::class, [
            'ownerRecord' => $character,
            'pageClass' => ViewCharacter::class,
        ])
            ->assertOk()
            ->assertCanSeeTableRecords($character->animes);
    }

    public function test_can_create_character(): void
    {
        Livewire::test(CreateCharacter::class)
            ->fillForm([
                'name' => 'Spike Spiegel',
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseHas(Character::class, [
            'name' => 'Spike Spiegel',
        ]);
    }

    public function test_can_update_character(): void
    {
        $character = Character::factory()->create();

        Livewire::test(EditCharacter::class, ['record' => $character->id])
            ->fillForm([
                'name' => 'Updated Character',
            ])
            ->call('save')
            ->assertNotified();

        $this->assertDatabaseHas(Character::class, [
            'id' => $character->id,
            'name' => 'Updated Character',
        ]);
    }

    public function test_create_page_renders(): void
    {
        Livewire::test(CreateCharacter::class)
            ->assertOk();
    }

    public function test_create_validates_required_fields(): void
    {
        Livewire::test(CreateCharacter::class)
            ->fillForm([
                'name' => null,
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required'])
            ->assertNotNotified();
    }

    public function test_edit_page_renders(): void
    {
        $character = Character::factory()->create();

        Livewire::test(EditCharacter::class, ['record' => $character->id])
            ->assertOk();
    }

    public function test_list_page_renders(): void
    {
        Character::factory()->count(3)->create();

        Livewire::test(ListCharacters::class)
            ->assertOk();
    }

    public function test_view_page_renders(): void
    {
        $character = Character::factory()->create();

        Livewire::test(ViewCharacter::class, ['record' => $character->id])
            ->assertOk();
    }

    public function test_view_page_renders_animes_relation_manager(): void
    {
        $character = Character::factory()->create();

        Livewire::test(ViewCharacter::class, ['record' => $character->id])
            ->assertSeeLivewire(AnimesRelationManager::class);
    }

    public function test_voice_actors_relation_manager_lists_related_voice_actors(): void
    {
        $character = Character::factory()->create();
        $anime = Anime::factory()->create();
        $person = Person::factory()->create();

        $character->voiceActors()->attach($person->id, [
            'anime_id' => $anime->id,
            'language' => 'Japanese',
        ]);

        Livewire::test(VoiceActorsRelationManager::class, [
            'ownerRecord' => $character,
            'pageClass' => ViewCharacter::class,
        ])
            ->assertOk()
            ->assertCanSeeTableRecords($character->voiceActors);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($this->admin);
    }
}
