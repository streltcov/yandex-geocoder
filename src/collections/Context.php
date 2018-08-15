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
 * Class Context
 *
 * @package streltcov\geocoder
 */
class Context extends GeoCollection implements QueryInterface
{

    /**
     * performs request to geocoder
     *
     * @param string $query
     * @return \stdClass
     */
    protected function request($query, array $parameters = null)
    {

        $current = $this->beforeRequest();

        if ($parameters['kind'] != null) {
            Api::setKind($parameters['kind']);
        }

        if ($parameters['skip'] != null) {
            echo "skip=" . $parameters['skip'] . PHP_EOL;
            Api::setSkip($parameters['skip']);
        }

        $response = (object)json_decode(Api::context($query))
            ->response
            ->GeoObjectCollection;

        $this->afterRequest($current);

        return $response;

    } // end function


    protected function parseParameters($parameters)
    {

        $result = [];

        if ($parameters != null) {
            if (isset($parameters['kind'])) {
                $result['kind'] = $parameters['kind'];
            }
            if (isset($parameters['skip'])) {
                $result['skip'] = $parameters['skip'];
            }
        }

        var_dump($result);

        return $result;

    } // end function


    /**
     *
     */
    protected function beforeRequest()
    {

    } // end function



    /**
     *
     */
    protected function afterRequest($current)
    {

        Api::setSkip((int)$current['skip']);
        Api::setKind((string)$current['kind']);

    } // end function

} // end class
