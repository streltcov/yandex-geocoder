<?php

namespace streltcov\geocoder\data;

use streltcov\geocoder\data\Response;
use streltcov\geocoder\errors\ErrorObject;
use streltcov\geocoder\components\GeoObject;
use streltcov\geocoder\interfaces\QueryInterface;

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
 * Class GeoData
 *
 * Contains Yandex geocoder response data
 *
 * @package streltcov\yandex-geocoder
 */
class GeoData extends Response implements QueryInterface
{

    protected $error = false;


    protected function request()
    {

    } // end function


    /**
     * @param $parameters
     */
    protected function selectCustom(array $parameters = null)
    {

    } // end function


    /**
     * @param string $address
     * @return string
     */
    /*private function filterAddress($address)
    {

        $address = explode(' ', $address);
        return trim(implode("+", $address));

    }*/ // end function



    /**
     * QueryInterface implementation
     */

} // end class