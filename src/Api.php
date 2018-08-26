<?php

namespace streltcov\geocoder;

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

    public static $responsecode;

    private static $api_url = 'https://geocode-maps.yandex.ru/1.x/?geocode=';


    /**
     * performs request to Yandex GeoCoder with set up parameters
     *
     * @param $address
     * @return string
     */
    public static function direct($address)
    {

        $response = '';
        $link = static::generateLink($address);
        return static::request($link);

    } // end function



    /**
     *
     * @param integer $skip
     * @param string $coordinates
     * @param string $kind
     * @return string
     */
    public static function context($coordinates)
    {

        $response = '';
        $link = static::generateLink($coordinates, true);
        return static::request($link);

    } // end function


    /**
     * @param $link
     */
    private static function request($link)
    {

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
    private static function generateLink($base, $flag = false)
    {
        $link = static::$api_url . $base . '&format=json';

        Config::get('lang') != null ? $lang = '&lang=' . Config::get('lang') : $lang = null;
        Config::get('skip') != null ? $skip = '&skip=' . Config::get('skip') : $skip = null;
        Config::get('kind') != null && $flag == true ? $kind = '&kind=' . Config::get('kind') : $kind = null;

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

} // end class
