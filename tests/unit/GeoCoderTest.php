<?php

namespace streltcov\geocoder\tests\unit;

use streltcov\geocoder\Config;
use streltcov\YandexUtils\GeoCoder;
use PHPUnit\Framework\TestCase;

require_once 'vendor/autoload.php';

class GeoCoderTest extends TestCase
{

    protected $geocoder;
    protected $search;
    protected $context;
    protected $address;
    protected $coordinates;
    protected $methods;

    protected function setUp()
    {

        $this->geocoder = new GeoCoder();
        $this->methods = get_class_methods(new GeoCoder());
        $this->address = 'TestAddress';
        $this->coordinates = '';
        $this->search = GeoCoder::search($this->address);
        $this->context = GeoCoder::searchPoint('');

    } // end function



    protected function tearDown()
    {

        $this->address = null;
        $this->geocoder = null;
        $this->methods = null;
        $this->context = null;
        $this->coordinates = null;
        $this->search = null;

        Config::reset();

    } // end function



    /**
     *
     */
    public function testMethodSearch()
    {

        $this->assertEquals('streltcov\geocoder\collections\Direct', get_class($this->search));

    } // end function



    /**
     *
     */
    public function testMethodSearchContext()
    {

        $this->assertEquals('streltcov\geocoder\collections\Context', get_class($this->context));

    } // end function



    /**
     *
     */
    public function testLocale()
    {

        $this->assertTrue(GeoCoder::locale('RU'));
        $this->assertEquals('ru_RU', Config::get('lang'));
        $this->assertTrue(GeoCoder::locale('EN'));
        $this->assertEquals('en_RU', Config::get('lang'));
        $this->assertTrue(GeoCoder::locale('US'));
        $this->assertEquals('en_US', Config::get('lang'));
        $this->assertTrue(GeoCoder::locale('UA'));
        $this->assertEquals('uk_UA', Config::get('lang'));
        $this->assertTrue(GeoCoder::locale('TR'));
        $this->assertEquals('tr_TR', Config::get('lang'));
        $this->assertTrue(GeoCoder::locale('BY'));
        $this->assertEquals('be_BY', Config::get('lang'));

    } // end function



    /**
     *
     */
    public function testKind()
    {

        $this->assertTrue(GeoCoder::kind('house'));
        $this->assertEquals('house', Config::get('kind'));
        $this->assertTrue(GeoCoder::kind('street'));
        $this->assertEquals('street', Config::get('kind'));
        $this->assertTrue(GeoCoder::kind('metro'));
        $this->assertEquals('metro', Config::get('kind'));
        $this->assertTrue(GeoCoder::kind('locality'));
        $this->assertEquals('locality', Config::get('kind'));
        $this->assertTrue(GeoCoder::kind('country'));
        $this->assertEquals('country', Config::get('kind'));
        $this->assertTrue(GeoCoder::kind('hydro'));
        $this->assertEquals('hydro', Config::get('kind'));

    } // end function



    /**
     *
     */
    public function testSkip()
    {

        $this->assertTrue(GeoCoder::skip(1));
        $this->assertEquals(1, Config::get('skip'));
        $this->assertTrue(GeoCoder::skip(2));
        $this->assertEquals(2, Config::get('skip'));
        $this->assertTrue(GeoCoder::skip(5));
        $this->assertEquals(5, Config::get('skip'));
        $this->assertTrue(GeoCoder::skip(10));
        $this->assertEquals(10, Config::get('skip'));
        $this->assertTrue(GeoCoder::skip(20));
        $this->assertEquals(20, Config::get('skip'));

    } // end function



    /**
     *
     */
    public function testMethods()
    {

        $expected = ['search', 'searchPoint', 'locale', 'kind', 'skip'];
        $this->assertTrue($expected == $this->methods);
        $this->assertEquals($expected, $this->methods);

    } // end function

} // end class
