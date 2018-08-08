<?php

namespace streltcov\YandexGeocoder;

use streltcov\geocoder\Api;
use streltcov\geocoder\data\Response;
use streltcov\geocoder\data\GeoData;
use streltcov\geocoder\data\ContextData;

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

        return Response::create('GeoData', $address);

    } // end function


    /**
     * creates and returns geocoder/Context object with requested coordinates
     *
     * @param string $kind
     * @param string $coordinates
     * @return ContextData
     */
    public static function searchContext($coordinates, $kind = null)
    {

        return new ContextData($coordinates, $kind);

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



    /**
     * sets global 'kind' parameter
     * will be applied to all context queries
     * (direct geocoder requests (with address parameter) does not support this parameter)
     *
     * @see Api::$kinds - available values for $kind argument
     * @param string $kind
     */
    public static function kind(string $kind)
    {

        Api::setKindGlobal($kind);

    } // end function


    /**
     * sets global 'skip' parameter
     * will be applied to all queries
     *
     * @param int $skip
     */
    public static function skip(int $skip)
    {

        Api::setSkipGlobal($skip);

    } // end function

} // end class
