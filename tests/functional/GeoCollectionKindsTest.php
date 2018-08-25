<?php

namespace streltcov\geocoder\tests;

use PHPUnit\Framework\TestCase;
use streltcov\YandexGeocoder\GeoCoder;

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

        $this->kind1 = GeoCoder::searchContext('37.600136 55.763832', ['kind' => 'metro'])->all();
        $this->kind2 = GeoCoder::searchContext('37.600136 55.763832', ['kind' => 'house']);

    } // end function



    /**
     *
     */
    public function testKind_1()
    {

        $this->assertEquals(10, count($this->kind1));
        foreach ($this->kind1 as $object) {
            $this->assertEquals('metro', $object->getKind());
        }

        $testcollection = GeoCoder::searchContext('37.600136 55.763832')->all();

        foreach ($testcollection as $object) {
            $this->assertNotEquals('metro', $object->getKind());
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
            $this->assertEquals('house', $object->getKind());
        }

        if ($this->kind2->hasExact()) {
            $this->assertEquals('house', $this->kind2->exact()->getKind());
        }

    } // end function

} // end function
