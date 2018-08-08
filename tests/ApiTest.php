<?php

namespace streltcov\geocoder\tests\unit;

use streltcov\geocoder\Api;
use PHPUnit\Framework\TestCase;

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
    protected $set_locale_method;
    protected $set_link_method;

    protected function setUp()
    {

        $this->api_reflection = new \ReflectionClass('streltcov\geocoder\Api');
        $this->set_locale_method = $this->api_reflection->getMethod('setLocale');
        $this->set_locale_method->setAccessible(true);
        $this->set_link_method = $this->api_reflection->getMethod('setLink');
        $this->set_link_method->setAccessible(true);
        $this->api = new Api();

    } // end function

    protected function tearDown()
    {

        $this->api = null;
        $this->api_reflection = null;
        $this->set_locale_method = null;
        $this->set_link_method = null;

    } // end function


    /**
     * testing setLocale method - if parameter is found in available
     * locale list will return true, else - return false
     */
    public function testLocale()
    {

        // correct cases - must return true
        $this->assertTrue($this->set_locale_method->invoke($this->api, 'RU'), 'Locale set correctly');
        $this->assertTrue($this->set_locale_method->invoke($this->api, 'EN'), 'Locale set correctly');
        $this->assertTrue($this->set_locale_method->invoke($this->api, 'BY'), 'Locale set correctly');
        $this->assertTrue($this->set_locale_method->invoke($this->api, 'UA'), 'Locale set correctly');
        $this->assertTrue($this->set_locale_method->invoke($this->api, 'US'), 'Locale set correctly');

        // false cases - must return false
        $this->assertFalse($this->set_locale_method->invoke($this->api, 'DE'), 'Locale parameter incorrect');
        $this->assertFalse($this->set_locale_method->invoke($this->api, 'FR'), 'Locale parameter incorrect');
        $this->assertFalse($this->set_locale_method->invoke($this->api, 'IT'), 'Locale parameter incorrect');
        $this->assertFalse($this->set_locale_method->invoke($this->api, 'GR'), 'Locale parameter incorrect');
        $this->assertFalse($this->set_locale_method->invoke($this->api, 'SP'), 'Locale parameter incorrect');

    } // end test


    public function testSetLink()
    {

        $coordinates = '37.587614 55.753083';

        // asserting default link parameters
        $this->assertEquals(
            'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=en_US',
            $this->set_link_method->invoke($this->api, $coordinates)
        );

        // asserting link with language parameters
        Api::setLocale('RU');
        $this->assertEquals(
            'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=ru_RU',
            $this->set_link_method->invoke($this->api, $coordinates)
        );
        Api::setLocale('BY');
        $this->assertEquals(
            'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=be_BY',
            $this->set_link_method->invoke($this->api, $coordinates)
        );
        Api::setLocale('EN');
        $this->assertEquals(
            'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=en_RU',
            $this->set_link_method->invoke($this->api, $coordinates)
        );
        Api::setLocale('UA');
        $this->assertEquals(
            'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=uk_UA',
            $this->set_link_method->invoke($this->api, $coordinates)
        );
        Api::setLocale('TR');
        $this->assertEquals(
            'https://geocode-maps.yandex.ru/1.x/?geocode=37.587614 55.753083&format=json&lang=tr_TR',
            $this->set_link_method->invoke($this->api, $coordinates)
        );

    } // end function

} // end class
