<?php

namespace App\Providers;

use App\Contracts\FileConverterInterface;
use App\Contracts\PhotoAnalyzerInterface;
use App\Services\FileConverters\CSVConverter;
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
        $this->app->bind(
            FileConverterInterface::class,
            CSVConverter::class
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
