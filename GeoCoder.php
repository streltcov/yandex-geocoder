<?php

namespace streltcov\YandexGeocoder;

use streltcov\geocoder\GeoData;
use streltcov\geocoder\Context;

/**
 * Class GeoCoder
 *
 * @package app\models\yandexcoder
 */
class GeoCoder
{

    /**
     * creates and returns GeoData object with address parameter
     *
     * @param string $address
     * @return GeoData
     */
    public static function search($address)
    {

        return new GeoData($address);

    } // end function


    /**
     * creates and returns geocoder/Context object with requested coordinates
     *
     * @param string $coordinates
     * @return Context
     */
    public static function searchContext($coordinates)
    {

        return new Context($coordinates);

    } // end function

} // end class
