<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Dto\PromotionVideoDto;
use App\Enums\AnimeTypeEnum;
use App\Models\Anime;
use App\Models\PromotionVideo;
use App\Services\AnimeImport\Processors\PromotionVideoProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromotionVideoProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function test_clear_deletes_promotion_videos(): void
    {
        $anime = Anime::factory()->create();
        PromotionVideo::query()->create([
            'anime_id' => $anime->id,
            'title' => 'PV 1',
            'video_url' => 'https://www.youtube.com/watch?v=abc123',
        ]);

        (new PromotionVideoProcessor())->clear($anime);

        $this->assertEquals(0, $anime->promotionVideos()->count());
    }

    public function test_sync_creates_promotion_videos(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new PromotionVideoDto(title: 'Trailer 1', videoUrl: 'https://www.youtube.com/watch?v=test1'),
            new PromotionVideoDto(title: 'PV 2', videoUrl: 'https://www.youtube.com/watch?v=test2'),
        ]);

        (new PromotionVideoProcessor())->sync($anime, $dto);

        $this->assertEquals(2, $anime->promotionVideos()->count());
        $this->assertDatabaseHas('promotion_videos', [
            'anime_id' => $anime->id,
            'title' => 'Trailer 1',
            'video_url' => 'https://www.youtube.com/watch?v=test1',
        ]);
    }

    public function test_sync_does_nothing_with_empty_videos(): void
    {
        $anime = Anime::factory()->create();

        (new PromotionVideoProcessor())->sync($anime, $this->makeDto([]));

        $this->assertEquals(0, $anime->promotionVideos()->count());
    }

    public function test_sync_updates_existing_video_by_url(): void
    {
        $anime = Anime::factory()->create();
        PromotionVideo::query()->create([
            'anime_id' => $anime->id,
            'title' => 'Old Title',
            'video_url' => 'https://www.youtube.com/watch?v=same_url',
        ]);

        $dto = $this->makeDto([
            new PromotionVideoDto(title: 'New Title', videoUrl: 'https://www.youtube.com/watch?v=same_url'),
        ]);

        (new PromotionVideoProcessor())->sync($anime, $dto);

        $this->assertEquals(1, $anime->promotionVideos()->count());
        $this->assertDatabaseHas('promotion_videos', ['title' => 'New Title']);
        $this->assertDatabaseMissing('promotion_videos', ['title' => 'Old Title']);
    }

    private function makeDto(array $videos): AnimeFullDto
    {
        return new AnimeFullDto(
            anime: new AnimeDto(malId: 1, title: 'Test', type: AnimeTypeEnum::TV),
            promotionVideos: $videos,
        );
    }
}
