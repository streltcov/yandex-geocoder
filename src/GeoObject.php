<?php

namespace streltcov\geocoder;

use streltcov\geocoder\interfaces\GeoObjectInterface;

/**
 * Class GeoObject
 * Contains data and description for a single instance in geocoder response
 *
 * @package streltcov\geocoder
 */
class GeoObject implements GeoObjectInterface
{

    public $metadata;
    public $description;
    public $name;
    public $coordinates;
    public $precision;
    public $locality;

    public function __construct(\stdClass $geoobject)
    {

        $response = $geoobject->GeoObject;
        $this->name = $response->name;
        $this->description = $response->description;
        $this->coordinates = $response->Point->pos;
        $this->metadata = $response->metaDataProperty->GeocoderMetaData;
        $this->precision = $this->metadata->precision;
        unset($response);

    } // end construct


    private function setLocality()
    {

    } // end function


    /**
     * @return bool
     */
    public function isExact()
    {

        $this->precision == 'exact' ? $exact = true : $exact = false;
        return $exact;

    } // end function


    /**
     * GETTERS
     */

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
     * @return mixed
     */
    public function getCoordinates()
    {
        return $this->coordinates;

    }  // end function

    /**
     * END GETTERS
     */

} // end class
