<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Enums\AnimeRatingEnum;
use App\Enums\PromotionVideoTypeEnum;
use App\Enums\SeasonOfYearEnum;
use App\Enums\WatchlistStatusEnum;
use App\Models\Anime;
use App\Models\User;
use App\Models\UserAnimeList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnumColumnTypesTest extends TestCase
{
    use RefreshDatabase;

    // AnimeRatingEnum::fromString

    public function test_rating_enum_parses_g_rating(): void
    {
        $this->assertSame(AnimeRatingEnum::G, AnimeRatingEnum::fromString('G - All Ages'));
    }

    public function test_rating_enum_parses_pg_rating(): void
    {
        $this->assertSame(AnimeRatingEnum::Pg, AnimeRatingEnum::fromString('PG - Children'));
    }

    public function test_rating_enum_parses_pg13_rating(): void
    {
        $this->assertSame(AnimeRatingEnum::Pg13, AnimeRatingEnum::fromString('PG-13 - Teens 13 or older'));
    }

    public function test_rating_enum_parses_r_rating(): void
    {
        $this->assertSame(AnimeRatingEnum::R, AnimeRatingEnum::fromString('R - 17+ (violence & profanity)'));
    }

    public function test_rating_enum_parses_r_plus_rating(): void
    {
        $this->assertSame(AnimeRatingEnum::RPlus, AnimeRatingEnum::fromString('R+ - Mild Nudity'));
    }

    public function test_rating_enum_parses_rx_rating(): void
    {
        $this->assertSame(AnimeRatingEnum::Rx, AnimeRatingEnum::fromString('Rx - Hentai'));
    }

    public function test_rating_enum_returns_null_for_unknown_rating(): void
    {
        $this->assertNull(AnimeRatingEnum::fromString('Unknown Rating'));
    }

    // SeasonOfYearEnum::fromString

    public function test_season_enum_parses_all_seasons(): void
    {
        $this->assertSame(SeasonOfYearEnum::Winter, SeasonOfYearEnum::fromString('winter'));
        $this->assertSame(SeasonOfYearEnum::Spring, SeasonOfYearEnum::fromString('spring'));
        $this->assertSame(SeasonOfYearEnum::Summer, SeasonOfYearEnum::fromString('summer'));
        $this->assertSame(SeasonOfYearEnum::Fall, SeasonOfYearEnum::fromString('fall'));
    }

    public function test_season_enum_is_case_insensitive(): void
    {
        $this->assertSame(SeasonOfYearEnum::Winter, SeasonOfYearEnum::fromString('Winter'));
        $this->assertSame(SeasonOfYearEnum::Spring, SeasonOfYearEnum::fromString('SPRING'));
    }

    public function test_season_enum_returns_null_for_unknown_season(): void
    {
        $this->assertNull(SeasonOfYearEnum::fromString('monsoon'));
    }

    // PromotionVideoTypeEnum values

    public function test_promotion_video_type_enum_has_expected_values(): void
    {
        $this->assertSame(1, PromotionVideoTypeEnum::Trailer->value);
        $this->assertSame(2, PromotionVideoTypeEnum::Pv->value);
        $this->assertSame(3, PromotionVideoTypeEnum::Character->value);
        $this->assertSame(4, PromotionVideoTypeEnum::Opening->value);
        $this->assertSame(5, PromotionVideoTypeEnum::Ending->value);
        $this->assertSame(6, PromotionVideoTypeEnum::Other->value);
    }

    // AnimeDto rating parsing

    public function test_anime_dto_from_array_parses_rating_string(): void
    {
        $dto = AnimeDto::fromArray([
            'mal_id' => 1,
            'title' => 'Test',
            'type' => 'TV',
            'rating' => 'PG-13 - Teens 13 or older',
        ]);

        $this->assertSame(AnimeRatingEnum::Pg13, $dto->rating);
    }

    public function test_anime_dto_from_array_sets_null_rating_for_unknown_string(): void
    {
        $dto = AnimeDto::fromArray([
            'mal_id' => 1,
            'title' => 'Test',
            'type' => 'TV',
            'rating' => 'Unknown - Something',
        ]);

        $this->assertNull($dto->rating);
    }

    public function test_anime_dto_from_array_sets_null_rating_when_absent(): void
    {
        $dto = AnimeDto::fromArray([
            'mal_id' => 1,
            'title' => 'Test',
            'type' => 'TV',
        ]);

        $this->assertNull($dto->rating);
    }

    // Anime model rating cast

    public function test_anime_model_casts_rating_to_enum(): void
    {
        $anime = Anime::factory()->create(['rating' => AnimeRatingEnum::R]);

        $fresh = Anime::query()->find($anime->id);

        $this->assertInstanceOf(AnimeRatingEnum::class, $fresh->rating);
        $this->assertSame(AnimeRatingEnum::R, $fresh->rating);
    }

    public function test_anime_model_allows_null_rating(): void
    {
        $anime = Anime::factory()->create(['rating' => null]);

        $fresh = Anime::query()->find($anime->id);

        $this->assertNull($fresh->rating);
    }

    // UserAnimeList model status cast

    public function test_user_anime_list_casts_status_to_enum(): void
    {
        $user = User::factory()->create();
        $anime = Anime::factory()->create();

        $list = UserAnimeList::query()->create([
            'user_id' => $user->id,
            'anime_id' => $anime->id,
            'status' => WatchlistStatusEnum::WATCHING,
        ]);

        $this->assertInstanceOf(WatchlistStatusEnum::class, $list->status);
        $this->assertSame(WatchlistStatusEnum::WATCHING, $list->status);

        $this->assertDatabaseHas('user_anime_lists', [
            'id' => $list->id,
            'status' => WatchlistStatusEnum::WATCHING->value,
        ]);
    }
}
