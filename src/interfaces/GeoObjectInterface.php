<?php

namespace streltcov\geocoder\interfaces;

use streltcov\geocoder\Context;

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
 * Interface GeoObjectInterface
 * @package streltcov\geocoder\interfaces
 */
interface GeoObjectInterface
{

    /**
     * checks if GeoObject contains exact location
     * @return boolean
     */
    public function isExact();


    /**
     * @return string
     */
    public function precision();


    /**
     * @param string $kind
     * @return \streltcov\geocoder\collections\Context
     */
    public function requestContext($kind);


    /**
     * GETTERS
     */


    /**
     * @return mixed
     */
    public function name();


    /**
     * @return mixed
     */
    public function description();


    /**
     * @return mixed
     */
    public function kind();


    /**
     * @return string
     */
    public function postalCode();


    /**
     * @return string
     */
    public function address();


    /**
     * @return string
     */
    public function countryCode();


    /**
     * @return string
     */
    public function country();


    /**
     * @return string
     */
    public function coordinates();


    /**
     * returns object coordinates
     *
     * @return array
     */
    public function point();


    /**
     * @return string
     */
    public function locality();


    /**
     * @return string
     */
    public function province();


    /**
     * @return string
     */
    public function street();
    

    /**
     * ENDGETTERS
     */

} // end interface
