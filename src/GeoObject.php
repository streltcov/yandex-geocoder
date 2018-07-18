<?php

namespace app\models\yandexgeo;

class GeoObject
{

    protected $response;


    public function __construct($response)
    {

        $this->response = $response;
        $this->geo = $this->init();

    } // end construct

    /**
     * checks if exist exact address in response
     *
     * @return boolean
     */
    public function isExact()
    {

        $exact = false;

        return $exact;

    }

} // end class