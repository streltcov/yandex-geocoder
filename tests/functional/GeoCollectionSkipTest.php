<?php

namespace streltcov\geocoder\tests;

use PHPUnit\Framework\TestCase;
use streltcov\YandexUtils\GeoCoder;

/**
 * Class GeoCollectionSkipTest
 *
 * @package streltcov\geocoder\tests
 */
class GeoCollectionSkipTest extends TestCase
{

    private $collection_1;
    private $collection_2;

    protected function setUp()
    {

        $this->collection_1 = GeoCoder::search('Тверская 18');
        $this->collection_2 = GeoCoder::search('Тверская 18', ['skip' => 5]);

    } // end function



    /**
     *
     */
    public function testCollection_1()
    {

        $this->assertEquals(5, (integer)$this->collection_2->metaData()->skip());

    } // end function



    /**
     *
     */
    public function testCollectionsData()
    {

        $this->assertEquals($this->collection_1->metaData()->request(), $this->collection_2->metaData()->request());

        // object #5 from 1st collection must be identic to object #o from second
        $object_1 = $this->collection_1->one(5);
        $object_2 = $this->collection_2->one();
        $this->assertEquals($object_1->name(), $object_2->name());
        $this->assertEquals($object_1->kind(), $object_2->kind());
        $this->assertEquals($object_1->address(), $object_2->address());
        $this->assertEquals($object_1->country(), $object_2->country());
        $this->assertEquals($object_1->coordinates(), $object_2->coordinates());
        $this->assertEquals($object_1->precision(), $object_2->precision());

    } // end function

} // end class
