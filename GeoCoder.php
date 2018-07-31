<?php

namespace streltcov\YandexGeocoder;

use streltcov\geocoder\Api;
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
     * @param string $kind
     * @param string $coordinates
     * @return Context
     */
    public static function searchContext($coordinates, $kind = null)
    {

        return new Context($coordinates, $kind);

    } // end function


    /**
     * sets query language
     * parameter $language should be in available list - else
     * other values will be ignored and request will be performed with default language
     *
     * @see Api
     * @param string $language
     */
    public static function setLocale($language)
    {

        Api::setLocale($language);

    } // end function

} // end class
