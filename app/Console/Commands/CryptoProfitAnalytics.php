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
    protected $signature = 'app:crypto-profit-analytics {buyPlatform} {sellPlatform}';

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

        $services = collect([
            $binancePriceService,
            $bybitPriceService,
            $jbexPriceService,
            $poloniexPriceService,
            $whitebitPriceService
        ]);

        $buyService = $services->where(function ($service){
            return $service->getPlatformName() == $this->argument('buyPlatform');
        })->first();

        $sellService = $services->where(function ($service){
            return $service->getPlatformName() == $this->argument('sellPlatform');
        })->first();
        $this->info("Buying in {$buyService->getPlatformName()} -> selling in {$sellService->getPlatformName()}");

        $profitPairs = $cryptoAnalyticsService->getAllPairsProfit($buyService, $sellService);
        foreach ($profitPairs as $pair) {
            $this->info("For pair \"{$pair['symbol']}\" profit={$pair['profit']}");
        }
    }
}
