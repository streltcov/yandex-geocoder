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
 * Class Context
 *
 * @package streltcov\geocoder
 */
class Context
{

    private $context;


    /**
     * Context constructor
     *
     * @param string $coordinates
     * @param string|null $kind
     */
    public function __construct($coordinates, $kind = null)
    {

        $response = json_decode(Api::requestContext($coordinates, $kind))->response;
        var_dump($response);

    } // end construct


    /**
     * returns object location district
     */
    public function getDistrict()
    {

        // TODO: implement method;

    } // end function



    /**
     * lists nearest metro stations
     */
    public function getNearestStations()
    {

        // TODO: implement method;

    } // end function

} // end class
