<?php

namespace streltcov\geocoder\collections;

use streltcov\geocoder\Api;
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
 * Contains Yandex geocoder response data for direct request (address)
 *
 * @see GeoCollection
 * @package streltcov\yandex-geocoder
 */
class Direct extends GeoCollection implements QueryInterface
{

    /**
     * performs request to geocoder
     *
     * @param string $query
     * @param string $kind
     * @param integer $skip
     * @return \stdClass
     */
    protected function requestBody($query, array $parameters = null)
    {

        $response = (object)json_decode(Api::direct($query, $parameters))
            ->response
            ->GeoObjectCollection;

        return $response;

    } // end function


    protected function parseParameters($parameters)
    {

        if (isset($parameters['lang'])) {
            return ['lang' => $parameters['lang']];
        }

    } // end function


    protected function beforeRequest()
    {
        // TODO: Implement beforeRequest() method.
    }

    protected function afterRequest($parameters)
    {
        // TODO: Implement afterRequest() method.
    }

} // end class