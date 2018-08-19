<?php

namespace streltcov\geocoder\tests\unit;

use streltcov\geocoder\Api;
use PHPUnit\Framework\TestCase;
use streltcov\geocoder\Config;

require_once 'vendor/autoload.php';

/**
 * Class ApiTest
 * Tests basic Api methods (including private)
 *
 * @package streltcov\geocoder\tests\unit
 */
class ApiTest extends TestCase
{

    protected $api_reflection;
    protected $api;
    protected $set_link_method;

    protected function setUp()
    {

        $this->api_reflection = new \ReflectionClass('streltcov\geocoder\Api');
        $this->set_link_method = $this->api_reflection->getMethod('generateLink');
        $this->set_link_method->setAccessible(true);
        $this->api = new Api();

    } // end function

    protected function tearDown()
    {

        $this->api = null;
        $this->api_reflection = null;
        $this->set_link_method = null;

    } // end function


    public function testSetLink()
    {

        $coordinates = '37.587614 55.753083';

        // asserting default link parameters
        $this->assertEquals(
            'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json',
            $this->set_link_method->invoke($this->api, $coordinates, true)
        );

        // asserting link with language parameters
        $this->assertEquals(
            'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json',
            $this->set_link_method->invoke($this->api, $coordinates)
        );

    } // end function



    public function testCombinedConfigApi()
    {

        $coordinates = '37.587614 55.753083';

        Config::setLocale('RU');
        $this->assertEquals(
            'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=ru_RU',
            $this->set_link_method->invoke($this->api, $coordinates)
        );

        Config::setLocale('BY');
        $this->assertEquals(
        'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=be_BY',
        $this->set_link_method->invoke($this->api, $coordinates)
        );

        Config::setLocale('EN');
        $this->assertEquals(
        'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=en_RU',
        $this->set_link_method->invoke($this->api, $coordinates)
        );

        Config::setLocale('UA');
        $this->assertEquals(
        'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=uk_UA',
        $this->set_link_method->invoke($this->api, $coordinates)
        );

        Config::setLocale('TR');
        $this->assertEquals(
        'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=tr_TR',
        $this->set_link_method->invoke($this->api, $coordinates)
        );

    } // end function

} // end class
