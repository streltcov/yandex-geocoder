<?php

namespace streltcov\geocoder;

class ErrorObject extends GeoObject
{

    public function __construct()
    {
        //parent::__construct($geoobject);
        $error_message = 'Error, no results found; please, check requested data';
        $this->description = $error_message;
        $this->name = $error_message;
        $this->envelope = $error_message;
        $this->precision = 'exact';
        $this->metadata = $error_message;

    } // end construct

} // end class