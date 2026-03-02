<?php

namespace App\Providers;

use App\Contracts\Services\TitleImport\TitleImportProvider;
use App\Services\TitleImport\Providers\AniDbTitleImportProvider;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Support\ServiceProvider;

class TitleImportServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $this->app->bind(TitleImportProvider::class, function (): TitleImportProvider {
            return new AniDbTitleImportProvider(
                client: (string) config('services.anidb.client', ''),
                clientVer: (string) config('services.anidb.client_ver', '1'),
            );
        });

        $this->app->singleton(TitleImportService::class, function ($app): TitleImportService {
            return new TitleImportService(
                provider: $app->make(TitleImportProvider::class),
            );
        });
    }
}
