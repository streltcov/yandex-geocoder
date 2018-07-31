<?php

namespace streltcov\geocoder;

/**
 * Class Context
 *
 * @package streltcov\geocoder
 */
class Context
{

    private $context;


    /**
     * Context constructor
     *
     * @param string $coordinates
     * @param string|null $kind
     */
    public function __construct($coordinates, $kind = null)
    {

        $response = json_decode(Api::requestContext($coordinates, $kind))->response;
        var_dump($response);

    } // end construct


    /**
     * returns object location district
     */
    public function getDistrict()
    {

        // TODO: implement method;

    } // end function



    /**
     * lists nearest metro stations
     */
    public function getNearestStations()
    {

        // TODO: implement method;

    } // end function

} // end class
