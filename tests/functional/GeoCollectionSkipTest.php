<?php

namespace streltcov\geocoder\tests;

use PHPUnit\Framework\TestCase;
use streltcov\YandexGeocoder\GeoCoder;

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

        $this->assertEquals(5, (integer)$this->collection_2->metaData()->getSkip());

    } // end function



    /**
     *
     */
    public function testCollectionsData()
    {

        $this->assertEquals($this->collection_1->metaData()->getRequest(), $this->collection_2->metaData()->getRequest());

    } // end function

} // end class
