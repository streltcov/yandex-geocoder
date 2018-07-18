<?php

namespace app\models\yandexgeo;

/**
 * Class Api
 *
 * @package yandex\geocoderapi
 */
class Api
{

    private static $api_url = 'https://geocode-maps.yandex.ru/1.x/?geocode=';
    private static $curl_options = [
        CURLOPT_HTTPGET => 1,
        CURLOPT_RETURNTRANSFER => 1
    ];


    public static function request($link_parameters)
    {

        $response = '';
        $link = static::$api_url . $link_parameters;

        $connection = curl_init();
        curl_setopt($connection, $link);

        $code = static::getCode();

        return $response;

    } // end function


    private static function getCode()
    {

    }



    public static function getContext($parameters = ['coordinates', 'kind'])
    {

        if ($parameters['kind'] == '') {
            $parameters['kind'] = 'metro';
        }

        $coordinates = implode(',', $parameters['coordinates']);

        $link = static::$api_url . $coordinates . '&kind=' . $parameters['kind'];

        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $link);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($connection);
        $responsecode = curl_getinfo($connection, CURLINFO_HTTP_CODE);

        curl_close($connection);

        if ($responsecode == '200') {
            return simplexml_load_string($response);
        } else {
            return $response . 'Response returned with code ' . $responsecode;
        }


    } // end function



    /**
     * returns featureElement from response where precision = exact
     *
     * @param $response
     * @return array
     */
    public static function getExact($response)
    {

        $searchresult = [];

        $response = json_decode(json_encode($response), TRUE);

        if (isset($response['GeoObjectCollection'])) {
            $result = $response['GeoObjectCollection']['featureMember'];
        } else {
            return false;
        }

        if (is_array($result)) {
            foreach ($result as $key => $featureMember) {
                if ($key == 'GeoObject') {
                    if (isset($featureMember['metaDataProperty']['GeocoderMetaData']['precision'])
                        && $featureMember['metaDataProperty']['GeocoderMetaData']['precision'] == 'exact') {
                        $searchresult = $featureMember;
                    }
                    $searchresult['coordinates'] = $featureMember['GeoObject']['boundedBy']['Envelope'];
                    $corner1 = explode(" ", $searchresult['coordinates']['lowerCorner']);
                    $corner2 = explode(" ", $searchresult['coordinates']['upperCorner']);
                    $searchresult['fc'] = [
                        round(($corner1[0] + $corner2[0]) / 2, 3),
                        round(($corner1[1] + $corner2[1]) / 2, 3)
                    ];
                    $searchresult['description'] = $featureMember['GeoObject']['description'];
                    //$searchresult['precision'] = $featureMember['GeoObject'][''][''];
                    $searchresult['name'] = $featureMember['GeoObject']['name'];
                }
            }
        }

        return $searchresult;

    } // end function



    /**
     * performs http-request to Yandex-Geocoder
     * returns xml-object
     *
     * @param array $parameters
     * @return \SimpleXMLElement|string
     */
    public static function getGeocode($parameters = ['address', 'json' => false, 'kind' => null])
    {

        if (isset($parameters['kind'])) {
            $kind = '&kind=' . $parameters['kind'];
        } else {
            $kind = '';
        }

        $parameters['json'] == true ? $format = '&format=json' : $format = '';

        $link = static::$api_url . $parameters['address'] . $format . $kind;

        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $link);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($connection);
        $responsecode = curl_getinfo($connection, CURLINFO_HTTP_CODE);

        curl_close($connection);

        if ($responsecode == '200') {
            return simplexml_load_string($response);
        } else {
            return $response . 'Response returned with code ' . $responsecode;
        }

    } // end function

} // end class
