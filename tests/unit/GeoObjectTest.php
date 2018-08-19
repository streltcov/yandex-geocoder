<?php

namespace streltcov\geocoder\tests;

use PHPUnit\Framework\TestCase;
use streltcov\geocoder\components\GeoObject;

/**
 * Class GeoObjectTest
 *
 * @package streltcov\geocoder\tests
 */
class GeoObjectTest extends TestCase
{

    protected $response;
    protected $geo_object;

    protected function setUp()
    {

        $geoobject = new \stdClass();
        $geoobject->name = 'test feature member';
        $geoobject->description = 'test description';
        $geoobject->Point = new \stdClass();
        $geoobject->Point->pos = '11111111111111';
        $geoobject->boundedBy = new \stdClass();
        $geoobject->boundedBy->Envelope = new \stdClass();
        $geoobject->boundedBy->Envelope->lowerCorner = 'left';
        $geoobject->boundedBy->Envelope->upperCorner = 'right';
        $geoobject->metaDataProperty = new \stdClass();
        $geoobject->metaDataProperty->GeocoderMetaData = new \stdClass();
        $geoobject->metaDataProperty->GeocoderMetaData->precision = 'exact';
        $geoobject->metaDataProperty->GeocoderMetaData->kind = 'test';
        $geoobject->metaDataProperty->GeocoderMetaData->text = 'test';
        $geoobject->metaDataProperty->GeocoderMetaData->Address = new \stdClass();
        $geoobject->metaDataProperty->GeocoderMetaData->Address->formatted = 'formatted address';
        $geoobject->metaDataProperty->GeocoderMetaData->Address->Components = new \stdClass();
        $geoobject->metaDataProperty->GeocoderMetaData->AddressDetails = new \stdClass();

        $this->response = [
            'GeoObject' => $geoobject
        ];

        $this->response = (object)$this->response;

        $this->geo_object = new GeoObject($this->response);

    } // end function



    /**
     * testing synthetically generated GeoObject (public methods and properties)
     */
    public function testGeoObjectBasic()
    {

        $this->assertEquals('exact', $this->geo_object->getPrecision());
        $this->assertEquals('test description', $this->geo_object->getDescription());
        $this->assertEquals('test', $this->geo_object->getKind());
        $this->assertEquals('11111111111111', $this->geo_object->getCoordinates());
        $this->assertEquals('test feature member', $this->geo_object->getName());
        $this->assertEquals(['lower' => 'left', 'upper' => 'right'], $this->geo_object->getPoint());
        $this->assertNull($this->geo_object->getStreet());
        $this->assertNull($this->geo_object->getLocality());
        $this->assertNull($this->geo_object->getProvince());
        $this->assertTrue(is_array($this->geo_object->getData()));
        $this->assertTrue(is_array($this->geo_object->getPoint()));

    } // end function

} // end class
