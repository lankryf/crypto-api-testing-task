<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

// Services
use App\Services\CryptoAnalyticsService;
use App\Services\CryptoPlatforms\BinancePriceService;
use App\Services\CryptoPlatforms\BybitPriceService;
use App\Services\CryptoPlatforms\JbexPriceService;
use App\Services\CryptoPlatforms\PoloniexPriceService;
use App\Services\CryptoPlatforms\WhitebitPriceService;


class CryptoAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crypto-analytics {inCurrency} {outCurrency}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analytics cryptocurrency data (gets min and max values of currency pairs)';

    /**
     * Execute the console command.
     */
    public function handle(
        BinancePriceService $binancePriceService,
        BybitPriceService $bybitPriceService,
        JbexPriceService $jbexPriceService,
        PoloniexPriceService $poloniexPriceService,
        WhitebitPriceService $whitebitPriceService,
        CryptoAnalyticsService $cryptoAnalyticsService
    )
    {
        $this->info(
            "Currencies pair: {$this->argument('inCurrency')}->{$this->argument('outCurrency')}"
        );
        $services = [
            $binancePriceService,
            $bybitPriceService,
            $jbexPriceService,
            $poloniexPriceService,
            $whitebitPriceService
        ];
        $prices = $cryptoAnalyticsService->getPricesFromPlatformServices(
            $services,
            $this->argument('inCurrency'),
            $this->argument('outCurrency')
        );
        $sortedPricesFromPlatforms = $prices->sortByDesc('price');
        $max = $sortedPricesFromPlatforms->first();
        $min = $sortedPricesFromPlatforms->last();
        $this->info("Max price = {$max['price']} from {$max['name']} platform");
        $this->info("Min price = {$min['price']} from {$min['name']} platform");
    }
}
