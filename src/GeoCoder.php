<?php

namespace app\models\yandexgeo;

/**
 * Class GeoCoder
 *
 * @package app\models\yandexcoder
 */
class GeoCoder
{

    public $GeoObject;

    /**
     *
     * @param string $geodata
     */
    public static function requestGeoObject($address, $type = null)
    {

        $type == null ? $type = 'xml' : $type = $type;

        $link = '';

        $response = Api::request($link);

        return $response;
        return new GeoObject($response);

    } // end function


    public static function requestMetaData($coordinates)
    {

        $link = '';

    }

} // end class
