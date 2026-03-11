<?php

namespace App\Providers;

use App\Contracts\Services\AnimeApi\AnimeDataProvider;
use App\Models\Genre;
use App\Models\Theme;
use App\Services\AnimeApi\JikanAnimeDataProvider;
use App\Services\AnimeImport\AnimeImportService;
use App\Services\AnimeImport\Processors\CharacterProcessor;
use App\Services\AnimeImport\Processors\CompanyProcessor;
use App\Services\AnimeImport\Processors\EpisodeProcessor;
use App\Services\AnimeImport\Processors\ExternalLinkProcessor;
use App\Services\AnimeImport\Processors\PromotionVideoProcessor;
use App\Services\AnimeImport\Processors\RelatedAnimeProcessor;
use App\Services\AnimeImport\Processors\SeasonProcessor;
use App\Services\AnimeImport\Processors\StaffProcessor;
use App\Services\AnimeImport\Processors\TaxonomyProcessor;
use App\Services\AnimeImport\Processors\TitleProcessor;
use Illuminate\Support\ServiceProvider;
use Jikan\JikanPHP\Client;

class AnimeImportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return Client::create();
        });

        $this->app->bind(AnimeDataProvider::class, function ($app) {
            return new JikanAnimeDataProvider(
                client: $app->make(Client::class),
                apiDelay: (int) config('services.anime_import.api_delay', 1),
            );
        });

        $this->app->singleton(AnimeImportService::class, function ($app) {
            $apiClient = $app->make(AnimeDataProvider::class);

            $baseProcessors = [
                new TitleProcessor(),
                new TaxonomyProcessor('genres', Genre::class, 'genres'),
                new TaxonomyProcessor('themes', Theme::class, 'themes'),
                new CompanyProcessor(),
                new SeasonProcessor(),
                new RelatedAnimeProcessor(),
                new ExternalLinkProcessor(),
            ];

            $detailProcessors = [
                new EpisodeProcessor(),
                new CharacterProcessor(),
                new StaffProcessor(),
                new PromotionVideoProcessor(),
            ];

            return new AnimeImportService(
                apiClient: $apiClient,
                processors: array_merge($baseProcessors, $detailProcessors),
                rateLimitDelay: (int) config('services.anime_import.rate_limit_delay', 2),
                apiDelay: (int) config('services.anime_import.api_delay', 1),
                baseProcessors: $baseProcessors,
            );
        });
    }
}
