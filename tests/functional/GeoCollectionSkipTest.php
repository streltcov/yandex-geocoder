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
        $this->assertEquals($object_1->getName(), $object_2->getName());
        $this->assertEquals($object_1->getKind(), $object_2->getKind());
        $this->assertEquals($object_1->getAddress(), $object_2->getAddress());
        $this->assertEquals($object_1->getCountry(), $object_2->getCountry());
        $this->assertEquals($object_1->getCoordinates(), $object_2->getCoordinates());
        $this->assertEquals($object_1->getPrecision(), $object_2->getPrecision());

    } // end function

} // end class
