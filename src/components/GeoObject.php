<?php

namespace streltcov\geocoder\components;

use streltcov\geocoder\collections\Context;
use streltcov\geocoder\collections\GeoCollection;
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
        $this->envelope = $response->boundedBy->Envelope;
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
     * @return Context
     */
    public function requestContext($kind = null, $skip = null)
    {

        $coordinates = $this->coordinates();
        $parameters['kind'] = $kind;
        $parameters['skip'] = $skip;
        return GeoCollection::createCollection('Context', $coordinates, $parameters);

    } // end function


    /**
     * GETTERS
     */


    /**
     * @return string
     */
    public function kind()
    {

        return $this->kind;

    } // end function



    /**
     * @return string
     */
    public function precision()
    {

        return $this->precision;

    } // end function



    /**
     * @return mixed
     */
    public function name()
    {

        return $this->name;

    } // end function


    /**
     * @return mixed
     */
    public function description()
    {

        return $this->description;

    } // end function


    /**
     * @return string
     */
    public function address()
    {

        return (string)$this->address;

    } // end function


    /**
     * returns current object coordinates (string value separated by spacebar)
     * @return string
     */
    public function coordinates()
    {

        return (string)$this->coordinates;

    } // end function


    public function postalCode()
    {

        return $this->postalcode;

    }


    /**
     * @return string
     */
    public function country()
    {

        return $this->country;

    } // end function


    /**
     * @return string
     */
    public function countryCode()
    {

        return $this->countrycode;

    } // end function



    /**
     *
     */
    public function province()
    {

        return $this->province;

    } // end function



    /**
     *
     */
    public function locality()
    {

        return $this->locality;

    } // end function


    /**
     *
     */
    public function street()
    {

        return $this->street;

    } // end function



    /**
     * @return array;
     */
    public function point()
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
        $data['name'] = $this->name();
        $data['description'] = $this->description();
        $data['coordinates'] = $this->coordinates();
        $data['kind'] = $this->kind();
        $data['country'] = $this->country();
        $data['postalcode'] = $this->postalCode();
        $data['locality'] = $this->locality();
        $data['address'] = $this->address();
        $data['street'] = $this->street();

        return $data;

    } // end function



    /**
     * END GETTERS
     */

} // end class
