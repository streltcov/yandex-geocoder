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
     * @param string $kind
     * @return Context
     */
    public function requestContext($kind);

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
    public function getAddress();


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
     * @return string
     */
    public function getLocality();


    /**
     * @return string
     */
    public function getProvince();


    /**
     * @return string
     */
    public function getStreet();
    

    /**
     * ENDGETTERS
     */

} // end interface
