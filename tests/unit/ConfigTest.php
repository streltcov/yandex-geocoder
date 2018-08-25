<?php

namespace streltcov\geocoder\tests;

use PHPUnit\Framework\TestCase;
use streltcov\geocoder\Config;

/**
 * Class ConfigTest
 *
 * @package streltcov\geocoder\tests
 */
class ConfigTest extends TestCase
{

    protected function tearDown()
    {

        Config::reset();

    } // end function


    /**
     * tests static method getConfig()
     */
    public function testConfigGetConfig()
    {

        $config = Config::getConfig();
        $this->assertInstanceOf('streltcov\geocoder\Config', $config);

    } // end function



    /**
     * tests static method reset()
     */
    public function testConfigReset()
    {

        Config::setKind('house');
        Config::setLocale('RU');
        Config::setSkip(3);

        Config::reset();

        $this->assertEquals(null, Config::get('kind'));
        $this->assertEquals(null, Config::get('skip'));
        $this->assertEquals(null, Config::get('lang'));

    } // end function



    /**
     * tests static method locale()
     */
    public function testConfigLocale()
    {

        $this->assertTrue(Config::setLocale('RU'));
        $this->assertTrue(Config::setLocale('US'));
        $this->assertTrue(Config::setLocale('TR'));
        $this->assertTrue(Config::setLocale('UA'));
        $this->assertTrue(Config::setLocale('EN'));
        $this->assertTrue(Config::setLocale('BY'));

        $this->assertFalse(Config::setLocale('BU'));
        $this->assertFalse(Config::setLocale('FR'));
        $this->assertFalse(Config::setLocale('DE'));
        $this->assertFalse(Config::setLocale('IT'));
        $this->assertFalse(Config::setLocale('SP'));
        $this->assertFalse(Config::setLocale('CZ'));

    } // end function



    /**
     * tests static method setKind()
     */
    public function testConfigKind()
    {

        $this->assertTrue(Config::setKind('house'));
        $this->assertTrue(Config::setKind('street'));
        $this->assertTrue(Config::setKind('hydro'));
        $this->assertTrue(Config::setKind('metro'));
        $this->assertTrue(Config::setKind('district'));
        $this->assertTrue(Config::setKind('locality'));
        $this->assertTrue(Config::setKind('province'));
        $this->assertTrue(Config::setKind('country'));
        $this->assertTrue(Config::setKind(null));

        $this->assertFalse(Config::setKind('home'));
        $this->assertFalse(Config::setKind('city'));

    } // end function



    /**
     * tests static method get()
     */
    public function testConfigGet()
    {

        $this->assertNull(Config::get('lang'));
        $this->assertNull(Config::get('skip'));
        $this->assertNull(Config::get('kind'));

        Config::setLocale('RU');
        $this->assertEquals('ru_RU', Config::get('lang'));

        Config::setLocale('US');
        $this->assertEquals('en_US', Config::get('lang'));

        Config::setLocale('EN');
        $this->assertEquals('en_RU', Config::get('lang'));

        Config::setLocale('UA');
        $this->assertEquals('uk_UA', Config::get('lang'));

        Config::setLocale('TR');
        $this->assertEquals('tr_TR', Config::get('lang'));

        Config::setLocale('BY');
        $this->assertEquals('be_BY', Config::get('lang'));

        Config::setKind('house');
        $this->assertEquals('house', Config::get('kind'));

        Config::setKind('street');
        $this->assertEquals('street', Config::get('kind'));

        Config::setKind('metro');
        $this->assertEquals('metro', Config::get('kind'));

        Config::setKind('country');
        $this->assertEquals('country', Config::get('kind'));

        Config::setKind('locality');
        $this->assertEquals('locality', Config::get('kind'));

        Config::setKind('province');
        $this->assertEquals('province', Config::get('kind'));

        Config::setKind('hydro');
        $this->assertEquals('hydro', Config::get('kind'));

        Config::setSkip(1);
        $this->assertEquals(1, Config::get('skip'));

        Config::setSkip(2);
        $this->assertEquals(2, Config::get('skip'));

        Config::setSkip(3);
        $this->assertEquals(3, Config::get('skip'));

    } // end function



    /**
     *
     */
    public function testConfigErrors()
    {

        Config::setError(true);
        $message = 'Error, check request';
        $this->assertEquals($message, Config::errorMessage());

        Config::setError(false);
        $message = null;
        $this->assertEquals($message, Config::errorMessage());

    } // end function

} // end class
