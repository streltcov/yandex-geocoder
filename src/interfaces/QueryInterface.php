<?php

namespace streltcov\geocoder\interfaces;

use streltcov\geocoder\GeoObject;

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
 * Interface QueryInterface
 * FluentInterface for GeoCollection query building
 *
 * @package streltcov\geocoder\interfaces
 */
interface QueryInterface
{

    /**
     * @return boolean
     */
    public function hasExact();

    /**
     * @return mixed
     */
    public function select();

    /**
     * @param $query
     * @return mixed
     */
    public function find($query);

    /**
     * @return mixed
     */
    public function exact();

    /**
     * @return mixed
     */
    public function one();

    /**
     * @return mixed
     */
    public function all();

} // end interface
