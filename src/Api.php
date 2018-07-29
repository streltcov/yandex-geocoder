<?php

namespace streltcov\geocoder;

/**
 * Class Api
 *
 * @package yandex\geocoderapi
 */
class Api
{

    private static $languages = [
        'RU' => 'ru-ru',
        'US' => 'en-us',
        'EN' => 'en-en'
    ];
    private static $api_url = 'https://geocode-maps.yandex.ru/1.x/?geocode=';
    private static $curl_options = [
        CURLOPT_HTTPGET => 1,
        CURLOPT_RETURNTRANSFER => 1
    ];


    private function initConnection(string $link)
    {

    } // end function


    public static function requestAddress($address)
    {

        $response = '';
        $link = static::$api_url . $address . '&format=json';
        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $link);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($connection);
        //$responsecode = curl_getinfo($connection, CURLINFO_HTTP_CODE);

        curl_close($connection);

        //$code = static::getCode();

        return $response;

    } // end function


    public static function requestContext($coordinates)
    {

        // TODO: implement method;

    } // end function


    private static function getCode()
    {

    }

} // end class
