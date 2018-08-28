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
     * @var integer
     */
    private $results;

    /**
     * @var integer
     */
    private $found;

    /**
     * @var null|integer
     */
    private $skip;

    /**
     * @var null|string
     */
    private $kind;

    public function __construct(\stdClass $data)
    {

        $this->request = $data->request;
        $this->responsecode = Api::$responsecode;
        $this->results = $data->results;
        $this->found = $data->found;
        isset($data->skip) ? $this->skip = $data->skip : $this->skip = null;
        isset($data->kind) ? $this->kind = $data->kind : $this->kind = null;

    } // end construct



    /**
     * @return mixed
     */
    public function request()
    {

        return $this->request;

    } // end function



    /**
     * @return int
     */
    public function results()
    {

        return (int)$this->results;

    } // end function



    public function found()
    {

        return (int)$this->found;

    } // end function



    public function responseCode()
    {

        return $this->responsecode;

    } // end function




    public function skip()
    {

        return $this->skip;

    } // end function



    public function kind()
    {

        return $this->kind;

    } // end function

} // end class
