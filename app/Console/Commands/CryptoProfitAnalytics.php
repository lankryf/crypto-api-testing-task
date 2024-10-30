<?php

namespace App\Console\Commands;

use App\Services\CryptoAnalyticsService;
use App\Services\CryptoPlatforms\BinancePriceService;
use App\Services\CryptoPlatforms\BybitPriceService;
use App\Services\CryptoPlatforms\JbexPriceService;
use App\Services\CryptoPlatforms\PoloniexPriceService;
use App\Services\CryptoPlatforms\WhitebitPriceService;
use Illuminate\Console\Command;

class CryptoProfitAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crypto-profit-analytics {platform} {inCurrency} {outCurrency}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analytics cryptocurrency profit from buying in one platform in selling in all other platforms';

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
        $buyPrice = $prices->where('name', $this->argument('platform'))->first();
        $sellPrices = $prices->where('name', '!=', $this->argument('platform'))->all();
        $this->info("Buying from {$buyPrice['name']} with price {$buyPrice['price']}");
        foreach ($sellPrices as $sellPrice) {
            $profit = $sellPrice['price'] - $buyPrice['price'];
            $this->info("Selling in {$sellPrice['name']} with price {$sellPrice['price']} => profit $profit {$this->argument('outCurrency')}");
        }
    }
}
