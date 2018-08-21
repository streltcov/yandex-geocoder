<?php

namespace streltcov\geocoder\tests;

use PHPUnit\Framework\TestCase;
use streltcov\geocoder\Config;
use streltcov\geocoder\errors\ErrorObject;

/**
 * Class ErrorObjectTest
 *
 * @package streltcov\geocoder\tests
 */
class ErrorObjectTest extends TestCase
{

    protected $object;

    protected function setUp()
    {

        $this->object = new ErrorObject();

    } // end function


    public function testObject()
    {

        $this->assertInstanceOf('streltcov\geocoder\errors\ErrorObject', $this->object);

    } // end function



    /**
     *
     */
    public function testGeoobjectMethodsFalse()
    {

        // testing default config parameters - should return null
        Config::setError(false);
        $this->assertEquals(null, $this->object->getDescription());
        $this->assertEquals(null, $this->object->getName());
        $this->assertEquals(null, $this->object->getStreet());
        $this->assertEquals(null, $this->object->getLocality());
        $this->assertEquals(null, $this->object->getAddress());
        $this->assertEquals(null, $this->object->getPostalCode());
        $this->assertEquals(null, $this->object->getCountry());
        $this->assertEquals(null, $this->object->getCountryCode());
        $this->assertEquals(null, $this->object->getPoint());
        $this->assertEquals(null, $this->object->getProvince());

    } // end function



    /**
     *
     */
    public function testGeoobjectMethodsTrue()
    {

        // setting error to false - should return text messages
        Config::setError(true);
        $this->assertEquals('Error, check request', $this->object->getDescription());
        $this->assertEquals('Error, check request', $this->object->getName());
        $this->assertEquals('Error, check request', $this->object->getStreet());
        $this->assertEquals('Error, check request', $this->object->getLocality());
        $this->assertEquals('Error, check request', $this->object->getAddress());
        $this->assertEquals('Error, check request', $this->object->getPostalCode());
        $this->assertEquals('Error, check request', $this->object->getCountry());
        $this->assertEquals('Error, check request', $this->object->getCountryCode());
        $this->assertEquals('Error, check request', $this->object->getPoint());
        $this->assertEquals('Error, check request', $this->object->getProvince());

    } // end function

} // end class
