<?php

namespace App\Console\Commands;

use App\Services\CryptoPlatforms\BinancePriceService;
use App\Services\CryptoPlatforms\BybitPriceService;
use App\Services\CryptoPlatforms\CryptoPlatformService;
use App\Services\CryptoPlatforms\JbexPriceService;
use App\Services\CryptoPlatforms\PoloniexPriceService;
use App\Services\CryptoPlatforms\WhitebitPriceService;

use Exception;
use Illuminate\Console\Command;

// Services
use Illuminate\Support\Facades\Log;

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
        WhitebitPriceService $whitebitPriceService
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
        $prices = collect();
        /* @var CryptoPlatformService $service **/
        foreach ($services as $service) {
            try {
                $price = $service->getPrice($this->argument('inCurrency'), $this->argument('outCurrency'));
                $prices->push(['name' => $service->getPlatformName(), 'price' => $price]);
            } catch (Exception $exception) {
                Log::warning($exception->getMessage());
            }
        }
        $sortedPricesFromPlatforms = $prices->sortByDesc('price');
        $min = $sortedPricesFromPlatforms->first();
        $max = $sortedPricesFromPlatforms->last();
        $this->info("Max price = {$max['price']} from {$max['name']} platform}");
        $this->info("Min price = {$min['price']} from {$min['name']} platform}");
    }
}
