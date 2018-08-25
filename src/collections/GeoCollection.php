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
 * Class GeoCollection
 * Contains collection metadata and GeoObjects
 * Provides fluent interface for geoobjects
 *
 * @package streltcov\geocoder
 */
abstract class GeoCollection implements QueryInterface
{

    protected $selected = [];

    protected $filter = false;

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
     * array, contains GeoObjects
     *
     * @var array
     */
    protected $geoObjects = [];


    /**
     * GeoCollection constructor
     *
     * @param string $query
     * @param array $parameters
     */
    final public function __construct($query, $parameters = null)
    {

        if (!$this->validateRequest($query)) {
            $query = '';
        }

        $parameters = $this->parseParameters($parameters);
        $api_response = $this->request($query, $parameters);
        $this->initClass($api_response);

    } // end construct





    /**
     * Abstract Methods; Define in child classes;
     */



    /**
     * @param string $request
     * @return boolean
     */
    abstract protected function validateRequest($request);



    /**
     * @param $data
     * @return mixed
     */
    abstract protected function initCustom($data);


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
     * @param array $parameters
     * @return \stdClass
     */
    final protected function request($query, array $parameters = null)
    {

        $current = $this->beforeRequest();
        $result = $this->requestBody($query, $parameters);
        $this->afterRequest($current);
        $this->response_code = Api::$responsecode;
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

        $this->initCustom($api_response->metaDataProperty->GeocoderResponseMetaData);
        $this->featureMember = $api_response->featureMember;

        $this->metaData->getFound() == 0 ? $this->error = true : $this->error = false;
        switch ($this->error) {
            case false:
                $this->initCollection();
                break;
            case true:
                $this->initErrorColection();
                break;
        }

    } // end function



    /**
     *
     *
     * @return array
     */
    final protected function isSelected()
    {

        if (count($this->selected) == 0 && $this->filter == true) {
            return $this->selected;
        } elseif (count($this->selected) == 0 && $this->filter == false) {
            return $this->geoObjects;
        } else {
            return $this->selected;
        }

    } // end function



    /**
     * sets selection parameters and results to zero;
     * should be used in 'resulting' methods (one() & all());
     */
    final protected function reset()
    {

        $this->filter = false;
        $this->selected = [];

    } // end function


    /**
     * End Final Methods;
     */



    /**
     * inits geoobjects for each found location
     *
     * @param \stdClass $response
     */
    protected function initCollection()
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
     * checks if exist objet with exact precision in response
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
     * filters geoobjects array with id (index) and kind parameters
     *
     * @param array $parameters
     * @return $this
     */
    public function select(array $parameters = null)
    {

        $this->selected = $this->isSelected();
        $this->filter = true;
        $selected = [];

        if (is_array($parameters)) {

            if (isset($parameters['id'])) {
                if (is_array($parameters['id'])) {
                    foreach ($this->selected as $key => $object) {
                        foreach ($parameters['id'] as $number) {
                            if ($number == $key) {
                                $selected[$key] = $object;
                            }
                        }
                    }
                } else {
                    if (isset($this->selected[$parameters['id']])) {
                        $selected[$parameters['id']] = $this->selected[$parameters['id']];
                    }
                }
            }

            if (count($selected) != 0) {
                $this->selected = $selected;
            }

            $kinds = [];

            if (isset($parameters['kind'])) {
                if (is_array($parameters['kind'])) {
                    foreach ($parameters['kind'] as $kind) {
                        foreach ($this->selected as $key => $object) {
                            if ($object->getKind() == $kind) {
                                $kinds[$key] = $object;
                            }
                        }
                    }
                } else {
                    foreach ($this->selected as $key => $object) {
                        if ($object->getKind() == $parameters['kind']) {
                            $kinds[$key] = $object;
                        }
                    }
                }
            } else {
                $kinds = $this->isSelected();
            }
        }

        $this->selected = $kinds;

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

        $find = $this->isSelected();

        foreach ($find as $object) {
            $data = $object->getData();
            $data = implode(' ', $data);
            if (strpos($data, $query)) {
                $search[] = $object;
            }
        } // endfor

        $this->selected = $search;

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

        $one = $this->isSelected();

        if ($number == null) {
            if (isset($one[0])) {
                $this->reset();
                return $one[0];
            }
        } else {
            if (array_key_exists($number, $one)) {
                $this->reset();
                return $one[$number];
            } else {
                if (isset($one[0])) {
                    $this->reset();
                    return $one[0];
                }
            }
        }

    } // end function


    /**
     * @return array|null
     */
    public function all()
    {

        $all = $this->isSelected();
        $this->reset();
        return $all;

    } // end function

    /**
     * End Fluent Interface
     */

} // end class
