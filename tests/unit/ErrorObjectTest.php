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
        $this->assertEquals(null, $this->object->description());
        $this->assertEquals(null, $this->object->name());
        $this->assertEquals(null, $this->object->street());
        $this->assertEquals(null, $this->object->locality());
        $this->assertEquals(null, $this->object->address());
        $this->assertEquals(null, $this->object->postalCode());
        $this->assertEquals(null, $this->object->country());
        $this->assertEquals(null, $this->object->countryCode());
        $this->assertEquals(null, $this->object->point());
        $this->assertEquals(null, $this->object->province());

    } // end function



    /**
     *
     */
    public function testGeoobjectMethodsTrue()
    {

        // setting error to false - should return text messages
        Config::setError(true);
        $this->assertEquals('Error, check request', $this->object->description());
        $this->assertEquals('Error, check request', $this->object->name());
        $this->assertEquals('Error, check request', $this->object->street());
        $this->assertEquals('Error, check request', $this->object->locality());
        $this->assertEquals('Error, check request', $this->object->address());
        $this->assertEquals('Error, check request', $this->object->postalCode());
        $this->assertEquals('Error, check request', $this->object->country());
        $this->assertEquals('Error, check request', $this->object->countryCode());
        $this->assertEquals('Error, check request', $this->object->point());
        $this->assertEquals('Error, check request', $this->object->province());

    } // end function

} // end class
