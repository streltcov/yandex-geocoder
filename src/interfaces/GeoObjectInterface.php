<?php

namespace streltcov\geocoder\interfaces;

/**
 * Interface GeoObjectInterface
 * @package streltcov\geocoder\interfaces
 */
interface GeoObjectInterface
{

    /**
     * checks if GeoObject contains exact location
     * @return boolean
     */
    public function isExact();

    /**
     * GETTERS
     */

    public function getPostalcode();

    public function getCountrycode();

    public function getCountry();

    /**
     * returns object coordinates
     *
     * @return
     */
    public function getPoint();
    

    /**
     * ENDGETTERS
     */

} // end interface
