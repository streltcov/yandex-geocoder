<?php

namespace streltcov\geocoder\components;

use streltcov\geocoder\data\ContextData;
use streltcov\geocoder\data\GeoCollection;
use streltcov\geocoder\interfaces\GeoObjectInterface;
use streltcov\geocoder\data\Response;

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
    protected $country;
    /**
     * @var string
     */
    protected $postalcode;
    /**
     * @var string
     */
    protected $countrycode;
    /**
     * @var string
     */
    protected $street = null;
    /**
     * @var string
     */
    protected $area;
    /**
     * @var string
     */
    protected $locality = null;
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
        if (isset($response->description)) {
            $this->description = $response->description;
        }
        $this->coordinates = $response->Point->pos;
        $this->envelope = (array)$response->boundedBy->Envelope;
        $metadata = $response->metaDataProperty->GeocoderMetaData;

        $this->init($metadata);

    } // end construct



    /**
     * sets up object properties from metaData of /stdClass response object
     *
     * @param $metadata
     */
    protected function init(\stdClass $metadata)
    {

        $this->precision = $metadata->precision;
        $this->kind = $metadata->kind;
        $this->address = $metadata->Address->formatted;

        if (isset($metadata->Address->postal_code)) {
            $this->postalcode = $metadata->Address->postal_code;
        } else {
            $this->postalcode = null;
        }

        $this->parseComponents($metadata->Address->Components);
        $this->parseAddressDetails($metadata->AddressDetails);
        
    } // end function


    /**
     * @param \stdClass $details
     */
    protected function parseAddressDetails(\stdClass $details)
    {

        if (isset($details->Country)) {
            $country = $details->Country;
            $this->country = $country->CountryName;
            $this->countrycode = $country->CountryNameCode;
        } else {
            $this->country = null;
            $this->countrycode = null;
        }
        if (isset($country->AdministrativeArea)) {
            $this->area = $country->AdministrativeArea->AdministrativeAreaName;
        }

    } // end function


    /**
     * @param $components
     */
    protected function parseComponents($components)
    {

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
        return GeoCollection::createCollection('Context', $coordinates);

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

        return $this->postalcode;

    }


    /**
     * @return string
     */
    public function getCountry()
    {

        return $this->country;

    } // end function


    /**
     * @return string
     */
    public function getCountryCode()
    {

        return $this->countrycode;

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
     * @return array
     */
    public function getData()
    {
        $data['name'] = $this->getName();
        $data['description'] = $this->getDescription();
        $data['coordinates'] = $this->getCoordinates();
        $data['kind'] = $this->getKind();
        $data['country'] = $this->getCountry();
        $data['postalcode'] = $this->getPostalcode();
        $data['locality'] = $this->getLocality();
        $data['address'] = $this->getAddress();
        $data['street'] = $this->getStreet();

        return $data;

    } // end function



    /**
     * END GETTERS
     */

} // end class
