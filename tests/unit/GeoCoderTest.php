<?php

namespace streltcov\geocoder\tests\unit;

use streltcov\YandexGeocoder\GeoCoder;
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
        $this->context = GeoCoder::searchContext('');
    }

    protected function tearDown()
    {
        $this->address = null;
        $this->geocoder = null;
        $this->methods = null;
        $this->context = null;
        $this->coordinates = null;
        $this->search = null;
    }

    public function testMethodSearch()
    {
        $this->assertEquals('streltcov\geocoder\GeoData', get_class($this->search));
    }

    public function testMethodSearchContext()
    {
        $this->assertEquals('streltcov\geocoder\ContextData', get_class($this->context));
    }

    public function testMethods()
    {
        $expected = ['search', 'searchContext', 'setLocale'];
        $this->assertTrue($expected == $this->methods);
        $this->assertEquals($expected, $this->methods);
    }

} // end class
