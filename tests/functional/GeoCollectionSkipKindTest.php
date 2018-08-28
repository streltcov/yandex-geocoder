<?php

namespace streltcov\geocoder\tests;

use PHPUnit\Framework\TestCase;
use streltcov\YandexUtils\GeoCoder;

/**
 * Class GeoCollectionSkipKindTest
 *
 * @package streltcov\geocoder\tests
 */
class GeoCollectionSkipKindTest extends TestCase
{

    private $collection;

    protected function setUp()
    {

        $this->collection = GeoCoder::searchPoint('37.600136 55.763832', [
            'lang' => 'TR',
            'kind' => 'house'
        ]);

    } // end function



    /**
     *
     */
    public function testCollection_1()
    {

        $this->assertEquals('house', $this->collection->metaData()->kind());

        $object = $this->collection->one();
        $this->assertEquals('Rusya', $object->getCountry());
        $this->assertEquals('Moskova', $object->getLocality());

        $all = $this->collection->all();

        foreach ($all as $item) {
            $this->assertEquals('Rusya', $item->getCountry());
        }

    } // end function

} // end class
