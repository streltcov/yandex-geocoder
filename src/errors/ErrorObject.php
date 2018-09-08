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

    public function description()
    {
        return Config::errorMessage();
    }

    public function name()
    {
        return Config::errorMessage();
    }

    public function street()
    {
        return Config::errorMessage();
    }

    public function address()
    {
        return Config::errorMessage();
    }

    public function locality()
    {
        return Config::errorMessage();
    }

    public function postalCode()
    {
        return Config::errorMessage();
    }

    public function country()
    {
        return Config::errorMessage();
    }

    public function coordinates()
    {
        return Config::errorMessage();
    }

    public function point()
    {
        return Config::errorMessage();
    }

    public function countryCode()
    {
        return Config::errorMessage();
    }

    public function precision()
    {
        return 'exact';
    }

    public function province()
    {
        return Config::errorMessage();
    }

    public function kind()
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
