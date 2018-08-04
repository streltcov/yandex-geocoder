<?php

namespace streltcov\geocoder\errors;

use streltcov\geocoder\components\GeoObject;

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
class ErrorObject extends GeoObject
{

    public function __construct()
    {

        // TODO: remove after update getExact() from GeoData
        $this->precision = 'exact';

        // error properties
        $error_message = 'Error, no results found; please, check requested data';
        $this->description = $error_message;
        $this->name = $error_message;
        $this->envelope = $error_message;
        $this->metadata = $error_message;
        $this->coordinates = $error_message;
        $this->address = $error_message;
        $this->addressdetails = $error_message;

    } // end construct


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
