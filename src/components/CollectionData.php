<?php

namespace streltcov\geocoder\components;

use streltcov\geocoder\Api;

/**
 * Class CollectionData
 * contains GeoCollection MetaData and Api response data
 *
 * @package streltcov\geocoder\components
 */
class CollectionData
{

    /**
     * @var
     */
    private $responsecode;

    /**
     * @var
     */
    private $request;

    /**
     * @var
     */
    private $results;

    /**
     * @var
     */
    private $found;

    public function __construct(\stdClass $data)
    {

        $this->responsecode = Api::$responsecode;
        $this->results = $data->results;
        $this->found = $data->found;

    } // end construct


    public function getResults()
    {

        return (int)$this->results;

    } // end function



    public function getFound()
    {

        return (int)$this->found;

    } // end function



    public function getResponseCode()
    {

        return $this->responsecode;

    } // end function

} // end class
