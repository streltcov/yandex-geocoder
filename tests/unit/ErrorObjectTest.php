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



    public function testGeoobjectMethods()
    {

        // testing default config parameters - should return null
        Config::setError(false);
        $this->assertEquals(null, $this->object->getDescription());
        $this->assertEquals(null, $this->object->getName());

        // setting error to false - should return text messages
        Config::setError(true);
        $this->assertEquals('Error, check request', $this->object->getDescription());
        $this->assertEquals('Error, check request', $this->object->getName());

    } // end function

} // end class
