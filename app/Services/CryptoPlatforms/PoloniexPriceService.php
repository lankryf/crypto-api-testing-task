<?php

namespace App\Services\CryptoPlatforms;

use Exception;
use Illuminate\Support\Facades\Http;

class PoloniexPriceService extends CryptoPlatformService
{
    public function getPrice(string $currencyIn, string $currencyOut): float
    {
        $currencyPair = strtolower($currencyIn . '_' . $currencyOut);
        $response = Http::get("https://api.poloniex.com/markets/{$currencyPair}/price");

        if ($response->successful()) {
            return (float) $response->json('price');
        }

        throw new Exception('Bad response from Poloniex');
    }
    public static function getPlatformName(): string
    {
        return 'poloniex';
    }
}
