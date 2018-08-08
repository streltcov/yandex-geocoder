<?php

namespace streltcov\geocoder;

use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Static_;

/**
 * Copyright 2018 Peter Streltsov
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License
 */

/**
 * Class Api
 *
 * @package yandex\geocoderapi
 */
class Api
{

    private static $responsecode;

    private static $lang = [
        'RU' => 'ru_RU',
        'US' => 'en_US',
        'EN' => 'en_RU',
        'UA' => 'uk_UA',
        'BY' => 'be_BY',
        'TR' => 'tr_TR'
    ];

    private static $kind = [
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


    /**
     * performs request to Yandex GeoCoder with set up parameters
     *
     * @param $address
     * @return string
     */
    public static function request($address)
    {

        $response = '';
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
     *
     * @param integer $skip
     * @param string $coordinates
     * @param string $kind
     * @return string
     */
    public static function requestContext($coordinates, $kind = null, $skip = null)
    {

        $response = '';

        if (!in_array($kind, static::$kind)) {
            $kind = null;
        }

        $link = static::setLink($coordinates, $kind, $skip);

        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $link);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($connection);
        static::$responsecode = curl_getinfo($connection, CURLINFO_HTTP_CODE);
        curl_close($connection);

        return $response;

    } // end function



    /**
     * creates query link from request string and current API parameters
     *
     * @param integer $skip
     * @param string $kind
     * @param string $base
     * @return string
     */
    private static function setLink($base, $kind = null, $skip = null)
    {

        $link = static::$api_url . $base . '&format=json';
        $kind != null ? $kind = $kind : $kind = '';

        if (static::$parameters['lang'] != null) {
            $lang = '&lang=' . static::$parameters['lang'];
        } else {
            $lang = '';
        }

        if (is_integer($skip)) {
            $skip = '&skip=' . $skip;
        } else {
            $skip = '';
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

    } // end function



    /**
     * sets locale for API request
     * available languages - russian, english, english(USA), belorussian, turkish, ukrainian
     * (values listed in static::$lang array)
     *
     * @param string $locale
     * @return boolean
     */
    public static function setLocale($locale)
    {

        if (in_array($locale, array_keys(static::$lang))) {
            static::$parameters['lang'] = static::$lang[$locale];
            return true;
        }

        return false;

    } // end function


    /**
     * sets global kind parameter
     *
     * @param $kind
     */
    public static function setKindGlobal($kind)
    {

        if (in_array($kind, static::$kind)) {
            static::$parameters['kind'] = $kind;
        }

    } // end function


    /**
     * sets global skip parameter
     *
     * @param $skip
     */
    public static function setSkipGlobal(int $skip)
    {

        static::$parameters['skip'] = (int)$skip;

    } // end function

} // end class
