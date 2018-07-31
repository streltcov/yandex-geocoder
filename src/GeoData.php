<?php

namespace streltcov\geocoder;

use streltcov\geocoder\interfaces\GeoDataInterface;

/**
 * Class GeoData
 * Contains Yandex geocoder response data
 *
 * @package app\models\yandexgeo
 */
class GeoData implements GeoDataInterface
{

    //private $address;
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
        //var_dump($response);
        $response = (object)$response->response->GeoObjectCollection;
        $this->init($response);
        var_dump($this->geocoderMetaData);

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

        var_dump($this->error);

        if ($this->error != false) {
            foreach ($this->featureMember as $geoobject) {
                $this->geoObjects[] = new GeoObject($geoobject);
            }
        } else {
            $this->geoObjects[] = new ErrorObject();
        }

    } // end function



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
     * @param int $num
     * @return mixed|string
     */
    public function setLocation(int $num)
    {

        if (isset($this->geoObjects[$num])) {
            return $this->geoObjects[$num];
        } else {
            return "Requested location is not set";
        }

    } // end function

} // end class