<?php

namespace Tests\Feature\Livewire;

use App\Enums\AnimeSortEnum;
use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Livewire\AnimeIndex;
use App\Models\Anime;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AnimeIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_anime_index_page(): void
    {
        Anime::factory()->count(3)->create();

        Livewire::test(AnimeIndex::class)
            ->assertOk()
            ->assertSee('Каталог аніме');
    }

    public function test_displays_anime_in_results(): void
    {
        $anime = Anime::factory()->create(['title' => 'Naruto Shippuden']);

        Livewire::test(AnimeIndex::class)
            ->assertSee('Naruto Shippuden');
    }

    public function test_displays_total_count(): void
    {
        Anime::factory()->count(5)->create();

        Livewire::test(AnimeIndex::class)
            ->assertSee('5');
    }

    public function test_empty_state_when_no_results(): void
    {
        Livewire::test(AnimeIndex::class)
            ->assertSee('Аніме не знайдено');
    }

    public function test_filters_by_genre(): void
    {
        $action = Genre::factory()->create(['mal_title' => 'Action', 'name' => 'Екшн']);
        $comedy = Genre::factory()->create(['mal_title' => 'Comedy', 'name' => 'Комедія']);

        $animeWithAction = Anime::factory()->create(['title' => 'Action Anime']);
        $animeWithAction->genres()->attach($action);

        $animeWithComedy = Anime::factory()->create(['title' => 'Comedy Anime']);
        $animeWithComedy->genres()->attach($comedy);

        Livewire::test(AnimeIndex::class)
            ->call('toggleGenre', 'action')
            ->assertSee('Action Anime')
            ->assertDontSee('Comedy Anime');
    }

    public function test_filters_by_min_score(): void
    {
        Anime::factory()->create(['title' => 'Low Rated', 'score' => 4.0]);
        Anime::factory()->create(['title' => 'High Rated', 'score' => 9.0]);

        Livewire::test(AnimeIndex::class)
            ->set('score', '8')
            ->assertSee('High Rated')
            ->assertDontSee('Low Rated');
    }

    public function test_filters_by_multiple_types(): void
    {
        $tv = Anime::factory()->create(['title' => 'TV Anime', 'type' => AnimeTypeEnum::TV]);
        $movie = Anime::factory()->create(['title' => 'Movie Anime', 'type' => AnimeTypeEnum::MOVIE]);
        $ova = Anime::factory()->create(['title' => 'OVA Anime', 'type' => AnimeTypeEnum::OVA]);

        Livewire::test(AnimeIndex::class)
            ->call('toggleType', 'tv')
            ->call('toggleType', 'movie')
            ->assertSee('TV Anime')
            ->assertSee('Movie Anime')
            ->assertDontSee('OVA Anime');
    }

    public function test_filters_by_status(): void
    {
        $airing = Anime::factory()->create(['title' => 'Airing Anime', 'status' => AnimeStatusEnum::AIRING]);
        $finished = Anime::factory()->create(['title' => 'Finished Anime', 'status' => AnimeStatusEnum::FINISHED]);

        Livewire::test(AnimeIndex::class)
            ->call('toggleStatus', 'airing')
            ->assertSee('Airing Anime')
            ->assertDontSee('Finished Anime');
    }

    public function test_filters_by_type(): void
    {
        $tv = Anime::factory()->create(['title' => 'TV Anime', 'type' => AnimeTypeEnum::TV]);
        $movie = Anime::factory()->create(['title' => 'Movie Anime', 'type' => AnimeTypeEnum::MOVIE]);

        Livewire::test(AnimeIndex::class)
            ->call('toggleType', 'tv')
            ->assertSee('TV Anime')
            ->assertDontSee('Movie Anime');
    }

    public function test_filters_by_year_range(): void
    {
        Anime::factory()->create(['title' => 'Old Anime', 'aired_from' => '2010-01-01']);
        Anime::factory()->create(['title' => 'New Anime', 'aired_from' => '2023-06-01']);

        Livewire::test(AnimeIndex::class)
            ->set('yearFrom', '2020')
            ->assertSee('New Anime')
            ->assertDontSee('Old Anime');
    }

    public function test_page_accessible_via_route(): void
    {
        $response = $this->get(route('anime.index'));

        $response->assertOk();
    }

    public function test_page_with_url_params(): void
    {
        Anime::factory()->create(['type' => AnimeTypeEnum::TV, 'title' => 'TV Show']);

        $response = $this->get(route('anime.index', ['type' => 'tv', 'sort' => 'score']));

        $response->assertOk()
            ->assertSee('TV Show');
    }

    public function test_reset_filters_clears_all(): void
    {
        Anime::factory()->create(['type' => AnimeTypeEnum::TV]);

        Livewire::test(AnimeIndex::class)
            ->set('search', 'test')
            ->call('toggleType', 'tv')
            ->call('toggleStatus', 'airing')
            ->call('toggleGenre', 'action')
            ->set('yearFrom', '2020')
            ->set('yearTo', '2024')
            ->set('score', '8')
            ->set('sort', 'score')
            ->call('resetFilters')
            ->assertSet('search', '')
            ->assertSet('type', '')
            ->assertSet('status', '')
            ->assertSet('genre', '')
            ->assertSet('yearFrom', '')
            ->assertSet('yearTo', '')
            ->assertSet('score', '')
            ->assertSet('sort', '');
    }

    public function test_search_filters_by_title(): void
    {
        Anime::factory()->create(['title' => 'Naruto']);
        Anime::factory()->create(['title' => 'Bleach']);

        Livewire::test(AnimeIndex::class)
            ->set('search', 'Naruto')
            ->assertSee('Naruto')
            ->assertDontSee('Bleach');
    }

    public function test_sort_by_score(): void
    {
        Anime::factory()->create(['title' => 'Low Score', 'score' => 5.0]);
        Anime::factory()->create(['title' => 'High Score', 'score' => 9.0]);

        $component = Livewire::test(AnimeIndex::class)
            ->set('sort', AnimeSortEnum::Score->value);

        $html = $component->html();
        $highPos = strpos($html, 'High Score');
        $lowPos = strpos($html, 'Low Score');

        $this->assertNotFalse($highPos);
        $this->assertNotFalse($lowPos);
        $this->assertLessThan($lowPos, $highPos, 'High score anime should appear before low score');
    }

    public function test_sort_by_title_ascending(): void
    {
        Anime::factory()->create(['title' => 'Zeta Anime']);
        Anime::factory()->create(['title' => 'Alpha Anime']);

        $component = Livewire::test(AnimeIndex::class)
            ->set('sort', AnimeSortEnum::TitleAsc->value);

        $html = $component->html();
        $alphaPos = strpos($html, 'Alpha Anime');
        $zetaPos = strpos($html, 'Zeta Anime');

        $this->assertNotFalse($alphaPos);
        $this->assertNotFalse($zetaPos);
        $this->assertLessThan($zetaPos, $alphaPos, 'Alpha should appear before Zeta in ascending order');
    }

    public function test_untoggle_type_removes_filter(): void
    {
        $tv = Anime::factory()->create(['title' => 'TV Anime', 'type' => AnimeTypeEnum::TV]);
        $movie = Anime::factory()->create(['title' => 'Movie Anime', 'type' => AnimeTypeEnum::MOVIE]);

        Livewire::test(AnimeIndex::class)
            ->call('toggleType', 'tv')
            ->assertDontSee('Movie Anime')
            ->call('toggleType', 'tv')
            ->assertSee('Movie Anime');
    }

    public function test_view_toggle_grid_and_list(): void
    {
        Anime::factory()->create();

        Livewire::test(AnimeIndex::class)
            ->assertSet('view', 'grid')
            ->set('view', 'list')
            ->assertSet('view', 'list');
    }
}
