<?php

namespace streltcov\geocoder;

use streltcov\geocoder\interfaces\GeoDataInterface;

/**
 * Class GeoObject
 * @package app\models\yandexgeo
 */
class GeoData implements GeoDataInterface
{

    //private $address;
    private $metaDataProperty;
    private $featureMember;
    private $geoObjects = [];


    public function __construct(string $address)
    {

        $address = $this->filterAddress($address);

        // getting response object (stdClass)
        $response = json_decode(Api::requestAddress($address));
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

        foreach ($this->featureMember as $geoobject) {
            $this->geoObjects[] = new GeoObject($geoobject);
        }

        //var_dump($this->featureMember);
        //var_dump($this->geoObjects);
        foreach ($this->geoObjects as $geo) {
            //var_dump($geo->description);
            //var_dump($geo->name);
            //var_dump($geo->coordinates);
            //var_dump($geo->precision);
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

} // end class