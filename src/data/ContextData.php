<?php

namespace streltcov\geocoder\data;

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
 * Class ContextData
 *
 * @package streltcov\geocoder
 */
class ContextData extends Response implements QueryInterface
{

    private $kinds_custom = [

    ];


    /**
     * performs request to geocoder
     *
     * @param string $query
     * @return \stdClass
     */
    protected function request($query, $kind = null, $skip = null)
    {

        return (object)json_decode(Api::requestContext($query))
            ->response
            ->GeoObjectCollection;

    } // end function



    /**
     * @param array $parameters
     */
    protected function selectCustom(array $parameters)
    {
        // TODO: Implement selectCustom() method.
    }

} // end class
