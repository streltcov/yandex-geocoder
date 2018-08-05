<?php

namespace streltcov\geocoder\interfaces;

use streltcov\geocoder\GeoObject;

/**
 * Interface QueryInterface
 * contains methods for geocoder query build
 *
 * @package streltcov\geocoder\interfaces
 */
interface QueryInterface
{

    /**
     * @return boolean
     */
    public function hasExact();

    public function select();

    public function exact();

    public function one();

    public function all();

} // end interface
