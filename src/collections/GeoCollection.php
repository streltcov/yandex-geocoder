<?php

namespace streltcov\geocoder\collections;

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
abstract class GeoCollection implements QueryInterface
{

    protected $response_code;

    protected $parameters = [
        'kind' => null,
        'skip' => null
    ];

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
    final public function __construct($query, $parameters = null)
    {

        $parameters = $this->parseParameters($parameters);
        $api_response = $this->request($query, $parameters);
        $this->response_code = Api::$responsecode;
        $this->initClass($api_response);

    } // end construct





    /**
     * Abstract Methods; Define in child classes;
     */


    /**
     * @param $parameters
     * @return mixed
     */
    abstract protected function parseParameters($parameters);


    /**
     * @param $query
     * @param array|null $parameters
     * @return mixed
     */
    abstract protected function requestBody($query, array $parameters = null);


    /**
     * @return void
     */
    abstract protected function beforeRequest();


    /**
     * @param $parameters array
     * @return void
     */
    abstract protected function afterRequest($parameters);



    /**
     * End Abstract Methods
     */






    /**
     * Final methods; MUST not be overrided;
     */

    /**
     * performs request to geocoder
     *
     * @param string $query
     * @param string $kind
     * @param integer $skip
     * @return \stdClass
     */
    final protected function request($query, array $parameters = null)
    {

        $current = $this->beforeRequest();
        $result = $this->requestBody($query, $parameters);
        $this->afterRequest($current);
        return $result;

    } // end function


    /**
     * initialization block
     * sets basic parameters and calls other initializing methods
     *
     * @param \stdClass $api_response
     */
    final protected function initClass($api_response)
    {

        $this->metaData = $api_response->metaDataProperty->GeocoderResponseMetaData;
        $this->results = (int)$this->metaData->results;
        $this->featureMember = $api_response->featureMember;

        $this->results == 0 ? $this->error = true : $this->error = false;
        switch ($this->error) {
            case false:
                $this->initCollection($api_response);
                break;
            case true:
                $this->initErrorColection();
                break;
        }

    } // end function


    /**
     * End Final Methods;
     */



    /**
     * inits geoobjects for each found location
     *
     * @param \stdClass $response
     */
    protected function initCollection(\stdClass $response)
    {

        foreach ($this->featureMember as $item) {
            $this->geoObjects[] = new GeoObject($item);
        }

    } // end function



    /**
     * inits geoobject properties with error object if nothing found or query incorrect
     *
     */
    protected function initErrorColection()
    {

        $this->geoObjects[] = new ErrorObject();

    } // end function


    
    /**
     * @param $class
     * @param $query
     * @return mixed
     */
    public static function createCollection($class, $query, $parameters = null)
    {

        $class_name = 'streltcov\geocoder\collections\\' . $class;
        return new $class_name($query, $parameters);

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



    /**
     * shows number of geoobjects found
     *
     * @return int
     */
    public function found()
    {

        return count($this->geoObjects);

    } // end function


    /**
     * Fluent Interface methods
     */


    /**
     * @param array $parameters
     * @return $this
     */
    public function select(array $parameters = null)
    {

        $objects = $this->geoObjects;
        $this->geoObjects = [];
        $id = [];
        //$kinds = [];

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
                    if (isset($objects[$parameters['id']])) {
                        $id[$parameters['id']] = $objects[$parameters['id']];
                    }
                }
            } else {
                $id = $objects;
            }

            $kinds = $id;

            if (isset($parameters['kind'])) {
                if (is_array($parameters['kind'])) {
                    foreach ($parameters['kind'] as $kind) {
                        foreach ($id as $key => $object) {
                            if ($object->getKind() == $kind) {
                                $kinds[$key] = $object;
                            }
                        }
                    }
                }
            } else {

            }
        }

        $this->geoObjects = $kinds;

        return $this;

    } // end function



    /**
     * checks data in GeoObjects using substring
     *
     * @param string $query
     * @return array
     */
    public function find($query)
    {

        $query = strtolower((string)$query);
        $search = [];

        foreach ($this->geoObjects as $object) {
            $data = $object->getData();
            $data = implode(' ', $data);
            if (strpos($data, $query)) {
                $search[] = $object;
            }
        } // endfor

        //return $search;
        $this->geoObjects = $search;

        return $this;

    } // end function



    /**
     * finds in geoobjects array item with property 'precision' set to 'exact'
     *
     * @return GeoObject|ErrorObject
     */
    public function exact()
    {

        foreach ($this->geoObjects as $geoObject) {
            if ($geoObject->isExact()) {
                return $geoObject;
            }
        }

        return new ErrorObject();

    } // end function


    /**
     * @param integer|null $number
     * @return GeoObject|null
     */
    public function one($number = null)
    {

        if ($number == null) {
            return array_shift($this->geoObjects);
        } else {
            if (array_key_exists($number, $this->geoObjects)) {
                return $this->geoObjects[$number];
            } else {
                return array_shift($this->geoObjects);
            }
        }

    } // end function


    /**
     * @return array|null
     */
    public function all()
    {

        return $this->geoObjects;

    } // end function

    /**
     * End Fluent Interface
     */

} // end class
