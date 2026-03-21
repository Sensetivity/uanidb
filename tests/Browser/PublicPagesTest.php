<?php

namespace Tests\Browser;

use App\Models\Anime;
use App\Models\Character;
use App\Models\Person;
use App\Models\Studio;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PublicPagesTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function runDatabaseMigrations(): void
    {
        $this->artisan('migrate:fresh');

        $this->app[Kernel::class]->setArtisan(null);
    }

    public function test_anime_catalog_page_loads(): void
    {
        Anime::factory()->count(3)->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/anime')
                ->assertSee('Каталог аніме')
                ->assertSee('Фільтри');
        });
    }

    public function test_anime_show_page_loads(): void
    {
        $anime = Anime::factory()->create(['title' => 'Frieren Test']);

        $this->browse(function (Browser $browser) use ($anime) {
            $browser->visit("/anime/{$anime->slug}")
                ->assertSee('Frieren Test');
        });
    }

    public function test_anime_show_page_returns_404_for_invalid_slug(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/anime/nonexistent-anime-slug')
                ->assertSee('404');
        });
    }

    public function test_character_show_page_loads(): void
    {
        $character = Character::factory()->create(['name' => 'Test Character']);

        $this->browse(function (Browser $browser) use ($character) {
            $browser->visit("/characters/{$character->slug}")
                ->assertSee('Test Character');
        });
    }

    public function test_characters_page_loads(): void
    {
        Character::factory()->create(['name' => 'Naruto Uzumaki']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/characters')
                ->assertSee('Персонажі');
        });
    }

    public function test_home_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('УкрАніме')
                ->assertSee('Аніме')
                ->assertSee('Персонажі');
        });
    }

    public function test_home_page_shows_trending_anime(): void
    {
        Anime::factory()->create(['title' => 'Test Trending Anime', 'score' => 9.5]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Популярне зараз');
        });
    }

    public function test_login_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Увійти')
                ->assertSee('Електронна пошта');
        });
    }

    public function test_navbar_navigation_works(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Аніме')
                ->assertPathIs('/anime')
                ->clickLink('Персонажі')
                ->assertPathIs('/characters')
                ->clickLink('Рейтинги')
                ->assertPathIs('/rankings');
        });
    }

    public function test_people_page_loads(): void
    {
        Person::factory()->create(['name' => 'Hayao Miyazaki']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/people')
                ->assertSee('Сейю');
        });
    }

    public function test_person_show_page_loads(): void
    {
        $person = Person::factory()->create(['name' => 'Test Person']);

        $this->browse(function (Browser $browser) use ($person) {
            $browser->visit("/people/{$person->slug}")
                ->assertSee('Test Person');
        });
    }

    public function test_profile_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/profile')
                ->assertSee('Профіль');
        });
    }

    public function test_rankings_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/rankings')
                ->assertSee('Рейтинги');
        });
    }

    public function test_register_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->assertSee('Зареєструватися');
        });
    }

    public function test_search_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/anime/search')
                ->assertSee('Пошук');
        });
    }

    public function test_seasons_page_loads(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/seasons')
                ->assertSee('Сезон');
        });
    }

    public function test_studio_show_page_loads(): void
    {
        $studio = Studio::factory()->create(['name' => 'Test Studio']);

        $this->browse(function (Browser $browser) use ($studio) {
            $browser->visit("/studios/{$studio->slug}")
                ->assertSee('Test Studio');
        });
    }

    public function test_studios_page_loads(): void
    {
        Studio::factory()->create(['name' => 'Studio Ghibli']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/studios')
                ->assertSee('Студії');
        });
    }
}
