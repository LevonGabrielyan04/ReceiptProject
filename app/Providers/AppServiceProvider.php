<?php

namespace App\Providers;

use App\Contracts\PhotoAnalyzerInterface;
use App\Services\PhotoAnalyzerIntegrations\GeminiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PhotoAnalyzerInterface::class,
            GeminiService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
