<?php

namespace streltcov\geocoder;

use phpDocumentor\Reflection\Types\Static_;

/**
 * Class Api
 *
 * @package yandex\geocoderapi
 */
class Api
{

    private static $response;
    private static $responsecode;

    private static $languages = [
        'RU' => 'ru-ru',
        'US' => 'en-us',
        'EN' => 'en-RU',
        'UA' => 'uk_UA',
        'BY' => 'be_BY',
        'TR' => 'tr_TR'
    ];

    private static $kinds = [
        'house',
        'street',
        'metro',
        'district',
        'locality'

    ];

    private static $parameters = [
        'kind' => null,
        'skip' => null,
        'lang' => null
    ];

    private static $api_url = 'https://geocode-maps.yandex.ru/1.x/?geocode=';
    private static $curl_options = [
        CURLOPT_HTTPGET => 1,
        CURLOPT_RETURNTRANSFER => 1
    ];


    private function initConnection(string $link)
    {

    } // end function


    /**
     * performs request to Yandex GeoCoder with set up parameters
     *
     * @param $address
     * @return mixed|string
     */
    public static function request($address)
    {

        $response = '';
        //$link = static::$api_url . $address . '&format=json';
        $link = static::setLink($address);
        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $link);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($connection);
        static::$responsecode = curl_getinfo($connection, CURLINFO_HTTP_CODE);
        curl_close($connection);

        return $response;

    } // end function


    /**
     * sets locale for API request
     *
     * @param string $locale
     */
    public static function setLocale($locale)
    {

        if (in_array($locale, static::$languages)) {
            static::$parameters['lang'] = static::$languages[$locale];
        }

    } // end function


    /**
     * creates query link from request string and current API parameters
     *
     * @param string $base
     * @return string
     */
    private static function setLink($base)
    {

        $link = static::$api_url . $base . '&format=json';
        $kind = '';
        $skip = '';

        if (static::$parameters['lang'] != null) {
            $lang = 'lang=' . static::$parameters['lang'];
        } else {
            $lang = '';
        }

        if (static::$parameters['kind'] != null && in_array(static::$parameters['kind'], static::$kinds)) {
            $kind = static::$parameters['kind'];
        }

        return $link . $lang . $kind . $skip;

    } // end function


    /**
     * gets current response code for current request
     *
     * @return string
     */
    private static function getResponseCode()
    {
        return static::$responsecode;
    }

} // end class
