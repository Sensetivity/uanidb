<?php

namespace Tests\Browser;

use App\Enums\CharacterRoleEnum;
use App\Models\Anime;
use App\Models\Character;
use App\Models\Episode;
use App\Models\Person;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AnimeTabsE2ETest extends DuskTestCase
{
    use DatabaseMigrations;

    public function runDatabaseMigrations(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->artisan('migrate:fresh', ['--drop-views' => true]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->app[Kernel::class]->setArtisan(null);
    }

    public function test_anime_show_displays_synopsis(): void
    {
        $anime = Anime::factory()->create([
            'title' => 'Test Anime',
            'synopsis_uk' => 'Це тестовий опис українською.',
        ]);

        $this->browse(function (Browser $browser) use ($anime) {
            $browser->visit("/anime/{$anime->slug}")
                ->assertSee('Це тестовий опис українською.');
        });
    }

    public function test_anime_tab_state_in_url(): void
    {
        $anime = Anime::factory()->create(['title' => 'URL Tab Anime']);

        $this->browse(function (Browser $browser) use ($anime) {
            $browser->visit("/anime/{$anime->slug}?tab=episodes")
                ->waitForText('Епізоди')
                ->assertQueryStringHas('tab', 'episodes');
        });
    }

    public function test_anime_tabs_show_empty_state(): void
    {
        $anime = Anime::factory()->create(['title' => 'Empty Anime']);

        $this->browse(function (Browser $browser) use ($anime) {
            $browser->visit("/anime/{$anime->slug}")
                ->waitForText('Огляд')
                ->clickLink('Епізоди')
                ->waitForText('Епізодів ще не додано')
                ->assertSee('Епізодів ще не додано');
        });
    }

    public function test_anime_tabs_switch_to_characters(): void
    {
        $anime = Anime::factory()->create(['title' => 'Char Test Anime']);
        $character = Character::factory()->create(['name' => 'Hero Character']);
        $anime->characters()->attach($character->id, ['role' => CharacterRoleEnum::Main->value]);

        $this->browse(function (Browser $browser) use ($anime) {
            $browser->visit("/anime/{$anime->slug}")
                ->waitForText('Огляд')
                ->clickLink('Персонажі')
                ->waitForText('Hero Character')
                ->assertSee('Hero Character');
        });
    }

    public function test_anime_tabs_switch_to_episodes(): void
    {
        $anime = Anime::factory()->create(['title' => 'Tab Test Anime']);
        Episode::factory()->create([
            'anime_id' => $anime->id,
            'number' => 1,
            'title' => 'First Episode Title',
        ]);

        $this->browse(function (Browser $browser) use ($anime) {
            $browser->visit("/anime/{$anime->slug}")
                ->waitForText('Огляд')
                ->clickLink('Епізоди')
                ->waitForText('First Episode Title')
                ->assertSee('First Episode Title');
        });
    }

    public function test_anime_tabs_switch_to_staff(): void
    {
        $anime = Anime::factory()->create(['title' => 'Staff Test Anime']);
        $person = Person::factory()->create(['name' => 'Famous Director']);
        $anime->people()->attach($person->id, ['role' => 'Director']);

        $this->browse(function (Browser $browser) use ($anime) {
            $browser->visit("/anime/{$anime->slug}")
                ->waitForText('Огляд')
                ->clickLink('Команда')
                ->waitForText('Famous Director')
                ->assertSee('Famous Director')
                ->assertSee('Director');
        });
    }
}
