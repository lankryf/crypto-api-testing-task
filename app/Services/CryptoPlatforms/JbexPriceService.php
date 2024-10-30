<?php

namespace App\Services\CryptoPlatforms;

use Exception;
use Illuminate\Support\Facades\Http;

class JbexPriceService extends CryptoPlatformService
{
    public function getPrice(string $currencyIn, string $currencyOut): float
    {
        $response = Http::get(
            "https://api.jbex.com/openapi/quote/v1/ticker/price?symbol=$currencyIn$currencyOut"
        );
        if ($response->successful()) {
            return (float) $response->json('price');
        }
        throw new Exception('Bad response from Jbex');
    }
    public static function getPlatformName(): string
    {
        return 'jbex';
    }
}
