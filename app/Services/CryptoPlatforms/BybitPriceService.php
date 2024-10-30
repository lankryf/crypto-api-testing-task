<?php

namespace App\Services\CryptoPlatforms;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class BybitPriceService extends CryptoPlatformService
{
    public function getPrice(string $currencyIn, string $currencyOut): float
    {
        $response = Http::get(
            "https://api.bybit.com/v5/market/tickers?category=inverse&symbol=$currencyIn$currencyOut"
        );
        if ($response->successful()) {
            return (float) $response->json('result.list')[0]['lastPrice'];
        }
        throw new Exception('Bad response from Bybit');
    }

    public static function getPlatformName(): string
    {
        return 'bybit';
    }

    public static function getPairs(): Collection
    {
        $response = Http::get(
            "https://api.bybit.com/v5/market/tickers?category=inverse"
        );
        if ($response->successful()) {
            $pairs = collect($response->json('result.list'));
            return $pairs->map(function ($item) {
                return [
                    'symbol' => $item['symbol'],
                    'price' => $item['lastPrice'],
                ];
            });
        }
        throw new Exception('Bad response from Bybit');
    }
}
