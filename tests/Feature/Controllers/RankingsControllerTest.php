<?php

namespace Tests\Feature\Controllers;

use App\Enums\RankingCategoryEnum;
use App\Models\Anime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RankingsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_accepts_category_parameter(): void
    {
        Anime::factory()->count(3)->create(['score' => 8.0]);

        $this->get(route('rankings', ['category' => 'popular']))
            ->assertOk()
            ->assertViewHas('category', RankingCategoryEnum::Popular);
    }

    public function test_index_falls_back_to_top_for_invalid_category(): void
    {
        $this->get(route('rankings', ['category' => 'invalid']))
            ->assertOk()
            ->assertViewHas('category', RankingCategoryEnum::Top);
    }

    public function test_index_paginates_results(): void
    {
        Anime::factory()->count(30)->create(['score' => 8.0]);

        $response = $this->get(route('rankings'));
        $animes = $response->viewData('animes');

        $this->assertCount(25, $animes->items());
        $this->assertEquals(30, $animes->total());
    }

    public function test_index_returns_ok(): void
    {
        Anime::factory()->count(3)->create(['score' => 8.5]);

        $this->get(route('rankings'))
            ->assertOk()
            ->assertViewHas('animes')
            ->assertViewHas('category', RankingCategoryEnum::Top);
    }

    public function test_index_returns_ok_with_empty_results(): void
    {
        $response = $this->get(route('rankings'));
        $response->assertOk();

        $this->assertEquals(0, $response->viewData('animes')->total());
    }
}
