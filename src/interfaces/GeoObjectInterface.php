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
    public function getPrecision();


    /**
     * @param string $kind
     * @return Context
     */
    public function requestContext($kind);


    /**
     * GETTERS
     */


    /**
     * @return mixed
     */
    public function getName();


    /**
     * @return mixed
     */
    public function getDescription();


    /**
     * @return mixed
     */
    public function getKind();


    /**
     * @return string
     */
    public function getPostalcode();


    /**
     * @return string
     */
    public function getAddress();


    /**
     * @return string
     */
    public function getCountryCode();


    /**
     * @return string
     */
    public function getCountry();


    /**
     * @return string
     */
    public function getCoordinates();


    /**
     * returns object coordinates
     *
     * @return array
     */
    public function getPoint();


    /**
     * @return string
     */
    public function getLocality();


    /**
     * @return string
     */
    public function getProvince();


    /**
     * @return string
     */
    public function getStreet();
    

    /**
     * ENDGETTERS
     */

} // end interface
