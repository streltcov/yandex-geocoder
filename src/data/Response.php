<?php

namespace streltcov\geocoder\components;

use streltcov\geocoder\Api;
use streltcov\geocoder\interfaces\QueryInterface;

/**
 * Class Component
 * @package streltcov\geocoder
 */
abstract class Response implements QueryInterface
{

    /**
     *
     */

    protected $metaData;
    protected $featureMember;
    protected $geoObjects = [];

    /**
     *
     */

    /**
     * Response constructor
     * @param $query
     */
    final public function __construct($query)
    {

        $api_response = (object)json_decode(Api::request($query));

        $this->init();

    } // end construct

    public static function create($class, $query)
    {

        return new $class($query);

    } // end function

    protected function init()
    {

    } // end function



    /**
     * checks if exist exact address in response
     *
     * @return boolean
     */
    public function hasExact()
    {

        $exact = false;

        foreach ($this->geoObjects as $geoObject) {
            if ($geoObject->isExact()) {
                $exact = true;
            }
        }

        return $exact;

    } // end function

} // end class
