<?php

namespace App\Providers;

use App\Transformers\AnimeTransformer;
use App\Transformers\Contracts\AnimeTransformerContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
