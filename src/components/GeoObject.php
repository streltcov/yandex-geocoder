<?php

namespace streltcov\geocoder\components;

use streltcov\geocoder\data\ContextData;
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
    protected $address;
    /**
     * @var string
     */
    protected $coordinates;
    /**
     * @var string
     */
    protected $precision;
    /**
     * @var string
     */
    protected $envelope;
    /**
     * @var string
     */
    protected $street = null;
    /**
     * @var string
     */
    protected $locality;
    /**
     * @var string
     */
    protected $province = null;
    /**
     * @var string
     */
    protected $kind;


    /**
     * GeoObject constructor
     *
     * @param \stdClass $geoobject
     */
    public function __construct(\stdClass $geoobject)
    {

        $response = $geoobject->GeoObject;
        $this->name = $response->name;
        $this->description = $response->description;
        $this->coordinates = $response->Point->pos;
        $this->envelope = (array)$response->boundedBy->Envelope;
        $metadata = $response->metaDataProperty->GeocoderMetaData;

        $this->init($metadata);

    } // end construct



    /**
     * @param $metadata
     */
    protected function init(\stdClass $metadata)
    {

        $this->precision = $metadata->precision;
        $this->kind = $metadata->kind;
        $this->address = $metadata->Address->formatted;

        $components = $metadata->Address->Components;

        foreach ($components as $item) {
            if ($item->kind == 'province' && $this->province == null) {
                $this->province = $item->name;
            } elseif ($item->kind == 'street') {
                $this->street = $item->name;
            } elseif ($item->kind == 'locality') {
                $this->locality = $item->name;
            }
        }
        
    } // end function



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
     * @param int $skip
     * @param string $kind
     * @return ContextData
     */
    public function requestContext($kind = null, $skip = null)
    {

        $coordinates = $this->getCoordinates();
        return new ContextData($coordinates, $kind);

    } // end function


    /**
     * GETTERS
     */


    /**
     * @return string
     */
    public function getKind()
    {

        return $this->kind;

    } // end function


    public function getHeader()
    {
        // TODO: Implement getHeader() method
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
    public function getAddress()
    {

        return (string)$this->address;

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
     *
     */
    public function getProvince()
    {

        return $this->province;

    } // end function



    /**
     *
     */
    public function getLocality()
    {

        return $this->locality;

    } // end function


    /**
     *
     */
    public function getStreet()
    {

        return $this->street;

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
