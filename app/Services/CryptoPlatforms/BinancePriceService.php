<?php

namespace App\Services\CryptoPlatforms;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Exception;

class BinancePriceService extends CryptoPlatformService
{
    public function getPrice(string $currencyIn, string $currencyOut): float
    {
        $response = Http::get('https://api.binance.com/api/v3/ticker/price', [
            'symbol' => "$currencyIn$currencyOut"
        ]);

        if ($response->successful()) {
            return (float) $response->json('price');
        }

        throw new Exception('Bad response from Binance');
    }

    public static function getPlatformName(): string
    {
        return 'binance';
    }

    public static function getPairs(): Collection
    {
        $response = Http::get('https://api.binance.com/api/v3/ticker/price');

        if ($response->successful()) {
            return collect($response->json());
        }

        throw new Exception('Bad response from Binance');
    }
}
