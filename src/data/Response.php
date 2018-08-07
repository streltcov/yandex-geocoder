<?php

namespace streltcov\geocoder\data;

use streltcov\geocoder\Api;
use streltcov\geocoder\components\GeoObject;
use streltcov\geocoder\errors\ErrorObject;
use streltcov\geocoder\interfaces\QueryInterface;

/**
 * Class Component
 *
 * @package streltcov\geocoder
 */
abstract class Response implements QueryInterface
{

    protected $kinds = [
        'house',
        'street',
        'metro',
        'district',
        'locality'
    ];

    /**
     * @var string
     */
    protected $request;

    /**
     * number of results found in response
     *
     * @var int
     */
    protected $results;

    /**
     * error flag
     * sets up true in case no valid results found
     *
     * @var bool
     */
    protected $error;

    /**
     * object, contains response metadata
     *
     * @var \stdClass
     */
    protected $metaData;

    /**
     * @var \stdClass
     */
    protected $featureMember;

    /**
     * array, contains GeoObject
     *
     * @var array
     */
    protected $geoObjects = [];


    /**
     * Response constructor
     * @param $query
     */
    final public function __construct($query)
    {

        $api_response = (object)json_decode(Api::request($query))
        ->response
        ->GeoObjectCollection;

        $this->metaData = $api_response->metaDataProperty->GeocoderResponseMetaData;
        $this->results = (int)$this->metaData->results;
        $this->featureMember = $api_response->featureMember;
        $this->results == 0 ? $this->error = true : $this->error = false;

        switch ($this->error) {
            case false:
                $this->init($api_response);
                break;
            case true:
                $this->initError($api_response);
                break;
        }

        //$this->geoObjects = array_unique($this->geoObjects);

    } // end construct


    
    /**
     * @param $class
     * @param $query
     * @return mixed
     */
    public static function create($class, $query)
    {

        $classname = 'streltcov\geocoder\data\\' . $class;
        return new $classname($query);

    } // end function



    /**
     * inits geoobjects for each found location
     *
     * @param \stdClass $response
     */
    protected function init(\stdClass $response)
    {

        foreach ($this->featureMember as $item) {
            $this->geoObjects[] = new GeoObject($item);
        }

    } // end function


    /**
     * inits geoobject properties with error object if nothing found or query incorrect
     *
     * @param \stdClass $response
     */
    protected function initError(\stdClass $response)
    {

        $this->geoObjects[] = new ErrorObject();

    } // end function



    /**
     * checks if exist exact result in response
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



    abstract protected function selectCustom(array $parameters);


    /**
     * @param null $parameters
     * @return $this
     */
    public function select($parameters = null)
    {

        $objects = $this->geoObjects;

        $id = [];

        if (is_array($parameters)) {

            if (isset($parameters['id'])) {
                if (is_array($parameters['id'])) {
                    foreach ($parameters['id'] as $num) {
                        foreach ($objects as $key => $object) {
                            if ($num == $key) {
                                $id[$key] = $object;
                            }
                        }
                    }
                } else {
                    $id = [];
                }
            }
        }

        $this->geoObjects = $id;

        $this->selectCustom();

        return $this;

    } // end function

} // end class
