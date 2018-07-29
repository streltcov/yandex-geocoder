<?php

namespace streltcov\geocoder\interfaces;

use streltcov\geocoder\GeoObject;

/**
 * Interface GeoDataInterface
 * @package streltcov\geocoder\interfaces
 */
interface GeoDataInterface
{

    /**
     * @return GeoObject
     */
    public function getExact();

    /**
     * @return boolean
     */
    public function isExact();

} // end interface
