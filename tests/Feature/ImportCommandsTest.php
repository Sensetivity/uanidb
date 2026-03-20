<?php

namespace Tests\Feature;

use App\Jobs\DownloadAnimeImagesJob;
use App\Jobs\ImportAnimeJob;
use App\Models\Anime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ImportCommandsTest extends TestCase
{
    use RefreshDatabase;

    public function test_download_images_command_for_all(): void
    {
        Queue::fake([DownloadAnimeImagesJob::class]);

        Anime::factory()->count(3)->create([
            'source_image_url' => 'https://example.com/image.jpg',
        ]);

        $this->artisan('import:download-images', ['--all' => true])
            ->assertSuccessful();

        Queue::assertPushed(DownloadAnimeImagesJob::class, 3);
    }

    public function test_download_images_command_for_specific_anime(): void
    {
        Queue::fake([DownloadAnimeImagesJob::class]);

        $anime = Anime::factory()->create(['mal_id' => 1]);

        $this->artisan('import:download-images', ['malId' => 1])
            ->assertSuccessful();

        Queue::assertPushed(DownloadAnimeImagesJob::class, function ($job) use ($anime) {
            $reflection = new \ReflectionClass($job);
            $animeIdProp = $reflection->getProperty('animeId');

            return $animeIdProp->getValue($job) === $anime->id;
        });
    }

    public function test_import_anime_with_queue_flag(): void
    {
        Queue::fake([ImportAnimeJob::class]);

        $this->artisan('import:anime', ['malId' => 1, '--queue' => true])
            ->assertSuccessful();

        Queue::assertPushed(ImportAnimeJob::class, function ($job) {
            $reflection = new \ReflectionClass($job);
            $malIdProp = $reflection->getProperty('malId');

            return $malIdProp->getValue($job) === 1;
        });
    }

    public function test_import_batch_with_queue_flag(): void
    {
        Queue::fake([ImportAnimeJob::class]);

        $this->artisan('import:anime-batch', ['--from' => 1, '--to' => 3, '--queue' => true])
            ->assertSuccessful();

        Queue::assertPushed(ImportAnimeJob::class, 3);
    }
}
