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
}
