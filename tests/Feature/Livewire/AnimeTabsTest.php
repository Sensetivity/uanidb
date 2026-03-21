<?php

namespace Tests\Feature\Livewire;

use App\Enums\CharacterRoleEnum;
use App\Livewire\Anime\AnimeTabs;
use App\Models\Anime;
use App\Models\Character;
use App\Models\Episode;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AnimeTabsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_can_render_with_overview_tab(): void
    {
        $anime = Anime::factory()->create(['synopsis' => 'Test synopsis']);

        Livewire::test(AnimeTabs::class, ['anime' => $anime])
            ->assertOk()
            ->assertSee('Огляд')
            ->assertSee('Test synopsis');
    }

    public function test_can_switch_to_characters_tab(): void
    {
        $anime = Anime::factory()->create();
        $character = Character::factory()->create(['name' => 'Test Character']);
        $anime->characters()->attach($character->id, ['role' => CharacterRoleEnum::Main->value]);

        Livewire::test(AnimeTabs::class, ['anime' => $anime])
            ->call('selectTab', 'characters')
            ->assertSee('Test Character')
            ->assertSee('Персонажі');
    }

    public function test_can_switch_to_episodes_tab(): void
    {
        $anime = Anime::factory()->create();
        Episode::factory()->create([
            'anime_id' => $anime->id,
            'number' => 1,
            'title' => 'Pilot Episode',
        ]);

        Livewire::test(AnimeTabs::class, ['anime' => $anime])
            ->call('selectTab', 'episodes')
            ->assertSee('Pilot Episode');
    }

    public function test_can_switch_to_staff_tab(): void
    {
        $anime = Anime::factory()->create();
        $person = Person::factory()->create(['name' => 'Director Name']);
        $anime->people()->attach($person->id, ['role' => 'Director']);

        Livewire::test(AnimeTabs::class, ['anime' => $anime])
            ->call('selectTab', 'staff')
            ->assertSee('Director Name')
            ->assertSee('Director');
    }

    public function test_shows_empty_state_for_empty_characters(): void
    {
        $anime = Anime::factory()->create();

        Livewire::test(AnimeTabs::class, ['anime' => $anime])
            ->call('selectTab', 'characters')
            ->assertSee('Персонажів ще не додано');
    }

    public function test_shows_empty_state_for_empty_episodes(): void
    {
        $anime = Anime::factory()->create();

        Livewire::test(AnimeTabs::class, ['anime' => $anime])
            ->call('selectTab', 'episodes')
            ->assertSee('Епізодів ще не додано');
    }

    public function test_shows_ukrainian_synopsis_when_available(): void
    {
        $anime = Anime::factory()->create([
            'synopsis' => 'English text',
            'synopsis_uk' => 'Українській текст',
        ]);

        Livewire::test(AnimeTabs::class, ['anime' => $anime])
            ->assertSee('Українській текст')
            ->assertDontSee('English text');
    }

    public function test_tab_syncs_with_url_query_string(): void
    {
        $anime = Anime::factory()->create();

        Livewire::test(AnimeTabs::class, ['anime' => $anime])
            ->call('selectTab', 'episodes')
            ->assertSet('activeTab', 'episodes');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }
}
