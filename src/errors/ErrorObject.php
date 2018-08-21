<?php

namespace streltcov\geocoder\errors;

use streltcov\geocoder\Config;
use streltcov\geocoder\interfaces\GeoObjectInterface;

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
 * Class ErrorObject
 *
 * @package streltcov\geocoder\errors
 */
class ErrorObject implements GeoObjectInterface
{

    public function __construct()
    {

    } // end construct

    public function isExact()
    {

        return true;

    }

    public function getDescription()
    {
        return Config::errorMessage();
    }

    public function getName()
    {
        return Config::errorMessage();
    }

    public function getStreet()
    {
        return Config::errorMessage();
    }

    public function getAddress()
    {
        return Config::errorMessage();
    }

    public function getLocality()
    {
        return Config::errorMessage();
    }

    public function getPostalcode()
    {
        return Config::errorMessage();
    }

    public function getCountry()
    {
        return Config::errorMessage();
    }

    public function getCoordinates()
    {
        return Config::errorMessage();
    }

    public function getPoint()
    {
        return Config::errorMessage();
    }

    public function getCountryCode()
    {
        return Config::errorMessage();
    }

    public function getPrecision()
    {
        return 'exact';
    }

    public function getProvince()
    {
        return Config::errorMessage();
    }


    /**
     * parent method redefinition - returns ContextError object instead Context object
     *
     * @param null $kind
     * @return \streltcov\geocoder\errors\ContextError
     */
    public function requestContext($kind = null)
    {

        return new ContextError();

    } // end function

} // end class
