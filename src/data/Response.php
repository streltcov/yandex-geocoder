<?php

namespace streltcov\geocoder\data;

use streltcov\geocoder\Api;
use streltcov\geocoder\components\GeoObject;
use streltcov\geocoder\errors\ErrorObject;
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
 * Class Component
 *
 * @package streltcov\geocoder
 */
abstract class Response implements QueryInterface
{

    protected $kinds = [
        'house',
        'street',
        'metro',
        'district',
        'locality'
    ];

    /**
     * @var string
     */
    protected $request;

    /**
     * number of results found in response
     *
     * @var int
     */
    protected $results;

    /**
     * error flag
     * sets up true in case no valid results found
     *
     * @var bool
     */
    protected $error;

    /**
     * object, contains response metadata
     *
     * @var \stdClass
     */
    protected $metaData;

    /**
     * @var \stdClass
     */
    protected $featureMember;

    /**
     * array, contains GeoObject
     *
     * @var array
     */
    protected $geoObjects = [];


    /**
     * Response constructor
     *
     * @param $query
     */
    final public function __construct($query)
    {

        $api_response = (object)json_decode(Api::request($query))
                ->response
                ->GeoObjectCollection;

        $this->metaData = $api_response->metaDataProperty->GeocoderResponseMetaData;
        $this->results = (int)$this->metaData->results;
        $this->featureMember = $api_response->featureMember;
        $this->results == 0 ? $this->error = true : $this->error = false;

        switch ($this->error) {
            case false:
                $this->init($api_response);
                break;
            case true:
                $this->initError($api_response);
                break;
        }

    } // end construct


    
    /**
     * @param $class
     * @param $query
     * @return mixed
     */
    public static function create($class, $query)
    {

        $classname = 'streltcov\geocoder\data\\' . $class;
        return new $classname($query);

    } // end function



    /**
     * inits geoobjects for each found location
     *
     * @param \stdClass $response
     */
    protected function init(\stdClass $response)
    {

        foreach ($this->featureMember as $item) {
            $this->geoObjects[] = new GeoObject($item);
        }

    } // end function


    /**
     * inits geoobject properties with error object if nothing found or query incorrect
     *
     * @param \stdClass $response
     */
    protected function initError(\stdClass $response)
    {

        $this->geoObjects[] = new ErrorObject();

    } // end function



    /**
     * checks if exist exact result in response
     *
     * @return boolean
     */
    public function hasExact()
    {

        $exact = false;

        foreach ($this->geoObjects as $geoObject) {
            if ($geoObject->isExact()) {
                $exact = true;
            }
        }

        return $exact;

    } // end function



    abstract protected function selectCustom(array $parameters);


    /**
     * @param null $parameters
     * @return $this
     */
    public function select($parameters = null)
    {

        $objects = $this->geoObjects;

        $id = [];

        if (is_array($parameters)) {

            if (isset($parameters['id'])) {
                if (is_array($parameters['id'])) {
                    foreach ($parameters['id'] as $num) {
                        foreach ($objects as $key => $object) {
                            if ($num == $key) {
                                $id[$key] = $object;
                            }
                        }
                    }
                } else {
                    if (isset($objects[$id])) {
                        $id = $objects[$id];
                    }
                }
            } else {
                $id = $objects;
            }
        }

        $this->geoObjects = $id;

        $this->selectCustom();

        return $this;

    } // end function

    public function exact()
    {

        foreach ($this->geoObjects as $geoObject) {
            if ($geoObject->isExact()) {
                return $geoObject;
            }
        }

        return new ErrorObject();

    } // end function


    public function one($number = null)
    {

        if ($number == null) {
            return array_shift($this->geoObjects);
        } else {
            if (array_key_exists($this->geoObjects[$number])) {
                return $this->geoObjects[$number];
            } else {
                return array_shift($this->geoObjects);
            }
        }

    } // end function


    public function all()
    {

        return $this->geoObjects;

    } // end function

} // end class
