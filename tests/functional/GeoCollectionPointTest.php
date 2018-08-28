<?php

namespace streltcov\geocoder\tests;

use PHPUnit\Framework\TestCase;
use streltcov\YandexUtils\GeoCoder;

/**
 * Class GeoCollectionPointTest
 *
 * @package streltcov\geocoder\tests
 */
class GeoCollectionPointTest extends TestCase
{

    protected $collection;

    protected function setUp()
    {

        $this->collection = GeoCoder::searchPoint('37.600136 55.763832');

    } // end function


    public function testBasic_1()
    {

        $this->assertInstanceOf('streltcov\geocoder\components\GeoObject', $this->collection->one());
        $this->assertEquals(8, count($this->collection->all()));

    } // end function


    public function testBasic_2()
    {

        $all = $this->collection->all();

        foreach ($all as $object) {
            $this->assertInstanceOf('streltcov\geocoder\components\GeoObject', $object);
        }

    } // end function


    public function testBasic_3()
    {

        $one = $this->collection->one();

        $this->assertInstanceOf('streltcov\geocoder\components\GeoObject', $one);

        $this->assertEquals('exact', (string)$one->getPrecision());
        $this->assertEquals('house', (string)$one->getKind());

    } // end function

} // end class
