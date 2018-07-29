<?php

namespace streltcov\YandexGeocoder;

use streltcov\geocoder\interfaces\GeoCoderInterface;
use streltcov\geocoder\GeoData;
use streltcov\geocoder\ContextObject;

/**
 * Class GeoCoder
 *
 * @package app\models\yandexcoder
 */
class GeoCoder implements GeoCoderInterface
{

    /**
     * creates and returns geodata object with address parameter
     *
     * @param string $address
     * @return GeoData
     */
    public static function search($address)
    {

        return new GeoData($address);

    } // end function


    /**
     * creates and returns context object with requested coordinates
     *
     * @param string $coordinates
     * @return ContextObject
     */
    public static function searchContext($coordinates)
    {

        return new ContextObject($coordinates);

    } // end function

} // end class
