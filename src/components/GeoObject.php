<?php

namespace streltcov\geocoder\components;

use streltcov\geocoder\components\Component;
use streltcov\geocoder\interfaces\GeoObjectInterface;

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
 * Class GeoObject
 * Contains data and description for a single instance in geocoder response
 *
 * @package streltcov\geocoder
 */
class GeoObject implements GeoObjectInterface
{

    /**
     * @var \stdClass
     */
    protected $metadata;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $coordinates;
    /**
     * @var string
     */
    protected $precision;
    /**
     * @var \stdClass
     */
    protected $address;
    /**
     * @var \stdClass
     */
    protected $addressdetails;
    /**
     * @var
     */
    protected $envelope;



    public function __construct(\stdClass $geoobject)
    {

        $response = $geoobject->GeoObject;
        $this->name = $response->name;
        $this->description = $response->description;
        $this->coordinates = $response->Point->pos;
        $this->envelope = $response->boundedBy->Envelope;
        $this->metadata = $response->metaDataProperty->GeocoderMetaData;
        $this->precision = $this->metadata->precision;
        $this->address = (object)$this->metadata->Address;
        $this->addressdetails = (object)$this->metadata->AddressDetails->Country;
        unset($response);

    } // end construct


    /**
     * checks if GeoObject contains exact location
     *
     * @return bool
     */
    public function isExact()
    {

        $this->precision == 'exact' ? $exact = true : $exact = false;
        return $exact;

    } // end function


    /**
     * creates and returns Context object with coordinates from current geoobject
     *
     * @param string $kind
     * @return Context
     */
    public function requestContext($kind = null)
    {

        $coordinates = $this->getCoordinates();
        return new Context($coordinates, $kind);

    } // end function


    /**
     * GETTERS
     */

    public function getKind()
    {
        // TODO: Implement getKind() method.
    }


    public function getHeader()
    {
        // TODO: Implement getHeader() method.
    }


    /**
     * @return mixed
     */
    public function getName()
    {

        return $this->name;

    } // end function


    /**
     * @return mixed
     */
    public function getDescription()
    {

        return $this->description;

    } // end function


    /**
     * @return string
     */
    public function getFormattedAddress()
    {

        return (string)$this->address->formatted;

    } // end function


    /**
     * returns current object coordinates (string value separated by spacebar)
     * @return string
     */
    public function getCoordinates()
    {

        return (string)$this->coordinates;

    } // end function


    public function getPostalcode()
    {
        // TODO: Implement getPostalcode() method.
    }


    /**
     * @return string
     */
    public function getCountry()
    {

        return $this->addressdetails->CountryName;

    } // end function


    /**
     * @return string
     */
    public function getCountryCode()
    {

        return $this->addressdetails->CountryNameCode;

    } // end function


    /**
     * @return array;
     */
    public function getPoint()
    {
        $point = [];
        $point['lower'] = $this->envelope->lowerCorner;
        $point['upper'] = $this->envelope->upperCorner;
        return $point;

    } // end function

    /**
     * END GETTERS
     */

} // end class
