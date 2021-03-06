<?php

namespace streltcov\YandexUtils;

use streltcov\geocoder\Api;
use streltcov\geocoder\Config;
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
     * @return GeoCollection
     */
    public static function search($address, array $parameters = null)
    {

        return GeoCollection::createCollection('Direct', $address, $parameters);

    } // end function


    /**
     * creates and returns geocoder/Context object with requested coordinates
     *
     * @param string $kind
     * @param string $coordinates
     * @return GeoCollection
     */
    public static function searchPoint($coordinates, $parameters = null)
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
     * @return boolean
     */
    public static function locale($language)
    {
        if(Config::setLocale($language)) {
            return true;
        }

        return false;

    } // end function



    /**
     * sets global 'kind' parameter
     * will be applied to all context queries
     * (direct geocoder requests (with address parameter) does not support this parameter)
     *
     * @see Api::$kinds - available values for $kind argument
     * @param string $kind
     * @return boolean
     */
    public static function kind($kind)
    {
        if (Config::setKind($kind)) {
            return true;
        }

        return false;

    } // end function



    /**
     * sets global 'skip' parameter
     * will be applied to all queries
     *
     * @param int $skip
     * @return boolean
     */
    public static function skip($skip)
    {
        if (Config::setSkip($skip)) {
            return true;
        }

        return false;

    } // end function

} // end class
