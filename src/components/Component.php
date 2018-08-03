<?php

namespace streltcov\geocoder\components;

/**
 * Class Component
 * @package streltcov\geocoder
 */
abstract class Component
{

    public $country_code;
    public $postal_code;
    public $formatted;
    public $components = [];

    abstract public function getKind();

    abstract public function getHeader();

} // end class
