<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

// services
use App\Services\CryptoPlatforms\BinancePriceService;
use App\Services\CryptoPlatforms\BybitPriceService;
use App\Services\CryptoPlatforms\JbexPriceService;
use App\Services\CryptoPlatforms\PoloniexPriceService;
use App\Services\CryptoPlatforms\WhitebitPriceService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BinancePriceService::class, function ($app) {
            return new BinancePriceService();
        });
        $this->app->bind(JbexPriceService::class, function ($app) {
            return new JbexPriceService();
        });
        $this->app->bind(BybitPriceService::class, function ($app) {
            return new BybitPriceService();
        });
        $this->app->bind(PoloniexPriceService::class, function ($app) {
            return new PoloniexPriceService();
        });
        $this->app->bind(WhitebitPriceService::class, function ($app) {
            return new WhitebitPriceService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Log::info('AppServiceProvider has been booted.');
    }
}
