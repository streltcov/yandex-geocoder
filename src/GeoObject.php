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

    /**
     * @var \stdClass
     */
    private $metadata;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $coordinates;
    /**
     * @var string
     */
    private $precision;
    /**
     * @var \stdClass
     */
    private $address;
    /**
     * @var \stdClass
     */
    private $addressdetails;
    /**
     * @var
     */
    private $envelope;



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
    public function getCountrycode()
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
