<?php

namespace streltcov\geocoder\interfaces;

use streltcov\geocoder\src\ContextObject;
use streltcov\geocoder\src\GeoData;

/**
 * Interface GeoCoderInterface
 * @package streltcov\geocoder\interfaces
 */
interface GeoCoderInterface
{

    /**
     * @param string $address
     * @return GeoData
     */
    public static function search($address);

    /**
     * @param string $context
     * @return ContextObject
     */
    public static function searchContext($context);

} // end interface
