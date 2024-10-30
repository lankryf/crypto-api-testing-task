<?php

namespace App\Services\CryptoPlatforms;

use Illuminate\Support\Collection;
use Exception;

abstract class CryptoPlatformService
{
    /**
     * @param string $currencyIn
     * @param string $currencyOut
     * @return float
     * @throws Exception
     */
    public abstract function getPrice(string $currencyIn, string $currencyOut): float;

    /**
     * @return string
     */
    public abstract static function getPlatformName(): string;

    /**
     * @return Collection
     */
    public abstract static function getPairs(): Collection;
}
