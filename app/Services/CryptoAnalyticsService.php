<?php

namespace App\Services;

use App\Services\CryptoPlatforms\CryptoPlatformService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;

class CryptoAnalyticsService
{
    /**
     * @param CryptoPlatformService[] $services
     * @param $currencyIn
     * @param $currencyOut
     * @return Collection
     */
    function getPricesFromPlatformServices(array $services, $currencyIn, $currencyOut): Collection
    {
        $prices = collect();
        foreach ($services as $service) {
            try {
                $price = $service->getPrice($currencyIn, $currencyOut);
                $prices->push(['name' => $service->getPlatformName(), 'price' => $price]);
            } catch (Exception $exception) {
                Log::warning($exception->getMessage());
            }
        }
        return $prices;
    }

    /**
     * @param CryptoPlatformService $buyService
     * @param CryptoPlatformService $sellService
     * @return Collection
     */
    function getAllPairsProfit(CryptoPlatformService $buyService, CryptoPlatformService $sellService): Collection
    {
        $buyPairs = $buyService->getPairs();
        Log::debug($buyPairs);
        $sellPairs = $sellService->getPairs();
        Log::debug($sellPairs);
        return $buyPairs->map(function ($buyPair) use ($sellPairs) {
            $sellPair = $sellPairs->firstWhere('symbol', $buyPair['symbol']);
            if ($sellPair) {
                return [
                    'symbol' => $buyPair['symbol'],
                    'profit' => $sellPair['price'] - $buyPair['price'],
                ];
            }
            return null;
        })->filter();
    }
}
