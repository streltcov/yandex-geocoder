<?php

namespace streltcov\YandexGeocoder;

use streltcov\geocoder\Api;
use streltcov\geocoder\collections\GeoCollection;

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

        return GeoCollection::createCollection('Direct', $address);

    } // end function


    /**
     * creates and returns geocoder/Context object with requested coordinates
     *
     * @param string $kind
     * @param string $coordinates
     * @return ContextData
     */
    public static function searchContext($coordinates, $parameters = null)
    {

        return GeoCollection::createCollection('Context', $coordinates, $parameters);

    } // end function


    /**
     * sets query language
     * parameter $language should be in available list - else
     * other values will be ignored and request will be performed with default language
     *
     * @see Api
     * @param string $language
     */
    public static function locale($language)
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

        Api::setKind($kind);

    } // end function


    /**
     * sets global 'skip' parameter
     * will be applied to all queries
     *
     * @param int $skip
     */
    public static function skip(int $skip)
    {

        Api::setSkip($skip);

    } // end function

} // end class
