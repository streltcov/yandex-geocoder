<?php

namespace streltcov\geocoder\tests\unit;

use PHPUnit\Framework\TestCase;
use streltcov\YandexGeocoder\GeoCoder;

/**
 * Class GeoDataTest
 *
 * @package streltcov\geocoder\tests\unit
 */
class GeoCollectionTest_3 extends TestCase
{

    private $collection;
    private $one;
    private $all;

    protected function setUp()
    {

        $this->collection = GeoCoder::search('Boulevard Saint-Germain, 127');
        $this->one = $this->collection->one();
        $this->all = $this->collection->all();

    } // end function



    /**
     *
     */
    public function testGeoCollection()
    {

        $this->assertTrue($this->collection->hasExact());
        $this->assertEquals(1, $this->collection->found());
        $this->assertInstanceOf('streltcov\geocoder\components\GeoObject', $this->collection->one());
        $this->assertInstanceOf('streltcov\geocoder\components\GeoObject', $this->collection->exact());

    } // end function



    /**
     *
     */
    public function testOne()
    {

        $this->assertInstanceOf('streltcov\geocoder\components\GeoObject', $this->one);

    } // end function



    /**
     *
     */
    public function testAll()
    {

        $this->assertEquals(1, count($this->all));

    } // end function

} // end class
