<?php

namespace App\Services\CryptoPlatforms;

use Exception;
use Illuminate\Support\Collection;
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
    public static function getPairs(): Collection
    {
        $response = Http::get(
            "https://api.poloniex.com/markets/price"
        );
        if ($response->successful()) {
            $pairs = collect($response->json());
            return $pairs->map(function ($item) {
                return [
                    'symbol' => str_replace('_', '', $item['symbol']),
                    'price' => $item['price'],
                ];
            });
        }
        throw new Exception('Bad response from Poloniex');
    }
}
