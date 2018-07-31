<?php

namespace streltcov\geocoder\interfaces;

use streltcov\geocoder\Context;

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
     * @return Context
     */
    public function requestContext();

    /**
     * GETTERS
     */

    /**
     * @return string
     */
    public function getPostalcode();

    /**
     * @return string
     */
    public function getCountryCode();

    /**
     * @return string
     */
    public function getCountry();

    /**
     * @return string
     */
    public function getCoordinates();

    /**
     * returns object coordinates
     *
     * @return array
     */
    public function getPoint();
    

    /**
     * ENDGETTERS
     */

} // end interface
