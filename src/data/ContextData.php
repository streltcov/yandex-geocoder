<?php

namespace streltcov\geocoder;

use streltcov\geocoder\interfaces\ContextInterface;
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
class ContextData implements QueryInterface, ContextInterface
{

    private $metaData;
    private $featureMember;

    /**
     * Context constructor
     *
     * @param string $coordinates
     * @param string|null $kind
     */
    public function __construct($coordinates, $kind = null)
    {

        $response = json_decode(Api::requestContext($coordinates, $kind))->response->GeoObjectCollection;
        //var_dump($response);
        $this->metaData = $response->metaDataProperty;
        $this->featureMember = $response->featureMember;
        //var_dump($this->featureMember);

    } // end construct


    /**
     * QueryInterface
     */

    public function isExact()
    {
        // TODO: Implement isExact() method.
    }

    public function exact()
    {
        // TODO: Implement exact() method.
    }


    public function select()
    {
        // TODO: Implement select() method.
    }


    public function one()
    {

        return $this->geoObjects[0];

    }

    public function all()
    {

        return $this->geoObjects;

    }

    /**
     * END INTERFACE
     */

    /**
     * ContextInterface
     */

    public function skip()
    {
        // TODO: Implement skip() method.
    }

    public function kind()
    {
        // TODO: Implement kind() method.
    }

    /**
     * END INTERFACE
     */

} // end class
