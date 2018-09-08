<?php

namespace streltcov\geocoder\tests;

use PHPUnit\Framework\TestCase;
use streltcov\YandexUtils\GeoCoder;

/**
 * Class GeoCollectionKindsTest
 *
 * @package streltcov\geocoder\tests
 */
class GeoCollectionKindsTest extends TestCase
{

    private $kind1;
    private $kind2;

    protected function setUp()
    {

        $this->kind1 = GeoCoder::searchPoint('37.600136 55.763832', ['kind' => 'metro']);
        $this->kind2 = GeoCoder::searchPoint('37.600136 55.763832', ['kind' => 'house']);

    } // end function



    /**
     * testing first collection - kind1
     */
    public function testKind_1()
    {

        // checking collection data
        $this->assertEquals('37.600136 55.763832', $this->kind1->metaData()->request());
        $this->assertEquals('metro', $this->kind1->metaData()->kind());
        $this->assertEquals(10, $this->kind1->metaData()->results());
        $this->assertEquals(200, (int)$this->kind1->metaData()->responseCode());
        //$this->assertEquals();

        // receiving geoobjects array
        $kind1 = $this->kind1->all();

        // object kind must be equal to requested
        $this->assertEquals(10, count($kind1));
        foreach ($kind1 as $object) {
            $this->assertEquals('metro', $object->kind());
        }

        // testing global parameters - must be dropped to defaults
        $testcollection = GeoCoder::searchPoint('37.600136 55.763832')->all();

        // kind should not be 'metro'
        foreach ($testcollection as $object) {
            $this->assertNotEquals('metro', $object->kind());
        }

    } // end function



    /**
     *
     */
    public function testKind_2()
    {

        $all = $this->kind2->all();
        $this->assertEquals(10, count($all));

        foreach ($all as $object) {
            $this->assertEquals('house', $object->kind());
        }

        if ($this->kind2->hasExact()) {
            $this->assertEquals('house', $this->kind2->exact()->kind());
        }

    } // end function

} // end function
