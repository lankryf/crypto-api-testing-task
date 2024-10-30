<?php

namespace App\Services\CryptoPlatforms;

use Exception;
use Illuminate\Support\Facades\Http;

class WhitebitPriceService extends CryptoPlatformService
{
    public function getPrice(string $currencyIn, string $currencyOut): float
    {
        $symbol = strtoupper($currencyIn . '_' . $currencyOut);
        $response = Http::get("https://whitebit.com/api/v1/public/ticker?market=$symbol");

        if ($response->successful()) {
            return (float) $response->json('result.last');
        }

        throw new Exception('Bad response from Whitebit');
    }

    public static function getPlatformName(): string
    {
        return 'whitebit';
    }
}
