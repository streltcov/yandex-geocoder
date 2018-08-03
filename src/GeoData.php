<?php

namespace streltcov\geocoder;

use streltcov\geocoder\errors\ErrorObject;
use streltcov\geocoder\components\GeoObject;
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
 * Contains Yandex geocoder response data
 *
 * @package streltcov\yandex-geocoder
 */
class GeoData implements QueryInterface
{

    private $geocoderMetaData;
    private $metaDataProperty;
    private $featureMember;
    private $geoObjects = [];

    private $error = false;

    //
    private $query;


    public function __construct(string $address)
    {

        $this->query = $address;

        $address = $this->filterAddress($address);

        // getting response object (stdClass)
        $response = json_decode(Api::request($address));
        $response = (object)$response->response->GeoObjectCollection;
        $this->init($response);

    } // end construct


    /**
     * @param \stdClass $response
     */
    private function init(\stdClass $response)
    {

        $this->metaDataProperty = $response->metaDataProperty;
        $this->featureMember = $response->featureMember;
        $this->geocoderMetaData = $this->metaDataProperty->GeocoderResponseMetaData;

        // checking found results - if 0 - error flag is set up
        $found = (int)$this->geocoderMetaData->found;
        $found != 0 ? $this->error = true : $this->error = false;

        switch ($this->error) {

        }

        //var_dump($this->error);

        if ($this->error != false) {
            foreach ($this->featureMember as $geoobject) {
                $this->geoObjects[] = new GeoObject($geoobject);
            }
        } else {
            $this->geoObjects[] = new ErrorObject();
        }

    } // end function


    /**
     *
     */
    private function initError()
    {

        $this->geoObjects[] = new ErrorObject();

    }


    /**
     * @param string $address
     * @return string
     */
    private function filterAddress($address)
    {

        $address = explode(' ', $address);
        return trim(implode("+", $address));

    } // end function



    /**
     * QueryInterface implementation
     */

    /**
     * checks if exist exact address in response
     *
     * @return boolean
     */
    public function isExact()
    {

        $exact = false;

        return $exact;

    } // end function


    /**
     * @param null $parameters
     * @return $this
     */
    public function select($parameters = null)
    {

        return $this;

    } // end function


    public function exact()
    {

        foreach ($this->geoObjects as $geoObject) {
            if ($geoObject->isExact()) {
                return $geoObject;
            }
        }

        return false;

    } // end function


    public function one($parameters = null)
    {

        if ($parameters == null) {
            return $this->geoObjects[0];
        }

    } // end function


    public function all()
    {

        return $this->geoObjects;

    } // end function

} // end class