<?php

namespace streltcov\geocoder;

use streltcov\geocoder\interfaces\GeoDataInterface;

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
class GeoData implements GeoDataInterface
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


    private function initf()
    {

        foreach ($this->featureMember as $geo) {
            $this->geoObjects = new GeoObject($geo);
        }

    }


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
     * GeoDataInterface implementation
     */

    /**
     * @return boolean|GeoObject
     */
    public function getExact()
    {

        foreach ($this->geoObjects as $geoObject) {
            if ($geoObject->isExact()) {
                return $geoObject;
            }
        }

        return false;

    } // end function


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
     * End interface
     */


    /**
     * @return array
     */
    public function getLocations()
    {

        return $this->geoObjects;

    } // end function


    /**
     * @param integer $num
     * @return mixed|string
     */
    public function setLocation($num)
    {

        if (isset($this->geoObjects[$num])) {
            return $this->geoObjects[$num];
        } else {
            return "Requested location is not set";
        }

    } // end function

} // end class