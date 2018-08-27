<?php

namespace streltcov\geocoder\tests;

use PHPUnit\Framework\TestCase;
use streltcov\YandexGeocoder\GeoCoder;

/**
 * class FluentInterfaceTest1
 *
 * @package streltcov\geocoder\tests
 */
class FluentInterfaceTest1 extends TestCase
{

    private $collection;

    protected function setUp()
    {

        $this->collection = GeoCoder::search('Тверская улица, дом 18');

    } // end function



    /**
     *
     */
    public function testFluentSelect()
    {

        $select = $this->collection->select(['id' => [0, 1, 2]])->all();
        $this->assertEquals(3, count($select));

        $kind = $this->collection->select(['kind' => 'house'])->all();
        $this->assertEquals(10, count($kind));

    } // end function



    /**
     *
     */
    public function testFluentSelect_2()
    {

        $kind = $this->collection->select(['kind' => 'house'])->all();
        $this->assertEquals(10, count($kind));

    } // emd function



    /**
     *
     */
    public function testFluentSelect_3()
    {

        $kind = $this->collection->select(['kind' => 'street'])->all();
        $this->assertEquals(0, count($kind));

    } // end function



    /**
     *
     */
    public function testFluentSelect_4()
    {

        $select = $this->collection->select(['id' => [0, 1, 2]])->all();
        $kind = $this->collection->select(['kind' => 'house'])->all();

        $this->assertEquals(3, count($select));
        $this->assertEquals(10, count($kind));

    } // end function



    /**
     *
     */
    public function testFluentSelect_5()
    {

        $exact = $this->collection->exact();
        $this->assertInstanceOf('streltcov\geocoder\components\GeoObject', $exact);
        $this->assertEquals(1, count($exact));

        $select = $this->collection->select(['id' => [2, 3, 5, 7, 8]])->all();
        $this->assertEquals(5, count($select));

        $one = $this->collection->one();
        $this->assertEquals(1, count($one));

    } // end function

} // end class
