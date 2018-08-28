<?php

namespace streltcov\geocoder\collections;

use streltcov\geocoder\Api;
use streltcov\geocoder\components\CollectionData;
use streltcov\geocoder\Config;
use streltcov\geocoder\interfaces\QueryInterface;

/**
 * Copyright 2018 Peter Streltsov
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License
 */

/**
 * Class Context
 *
 * @package streltcov\geocoder
 */
class Context extends GeoCollection implements QueryInterface
{


    /**
     * @param string $request
     * @return bool|false|int
     */
    protected function validateRequest($request)
    {

        if (preg_match("/(^[0-9]{2}.[0-9]{1,}.{1,}[0-9]{2}.[0-9]{1,})/", $request)) {
            return true;
        }

        return false;

    } // end function



    /**
     * @param $data
     * @return mixed|void
     */
    protected function initCustom($data)
    {

        $this->metaData = new CollectionData($data);

    } // end function



    /**
     * performs request to geocoder
     *
     * @param string $query
     * @return \stdClass
     */
    protected function requestBody($query, array $parameters = null)
    {

        $current = $this->beforeRequest();

        if (isset($parameters['kind'])) {
            if ($parameters['kind'] != null) {
                Config::setKind($parameters['kind']);
            }
        }

        if (isset($parameters['skip'])) {
            if ($parameters['skip'] != null) {
                Config::setSkip($parameters['skip']);
            }
        }

        if (isset($parameters['lang'])) {
            if ($parameters['lang'] != null) {
                Config::setLocale($parameters['lang']);
            }
        }

        $this->raw = Api::context($query);
        $response = (object)(json_decode($this->raw))->response->GeoObjectCollection;

        $this->afterRequest($current);

        return $response;

    } // end function



    /**
     * @param $parameters
     * @return array|mixed
     */
    protected function parseParameters($parameters)
    {

        $result = [];

        if ($parameters != null) {
            if (isset($parameters['kind'])) {
                $result['kind'] = $parameters['kind'];
            }
            if (isset($parameters['skip'])) {
                $result['skip'] = $parameters['skip'];
            }
            if (isset($parameters['lang'])) {
                $result['lang'] = $parameters['lang'];
            }
        }

        return $result;

    } // end function


    /**
     *
     */
    protected function beforeRequest()
    {

        $current['skip'] = Config::get('skip');
        $current['kind'] = Config::get('kind');
        $current['lang'] = Config::get('lang');
        return $current;

    } // end function



    /**
     *
     */
    protected function afterRequest($current)
    {

        Config::setSkip((int)$current['skip']);
        Config::setKind($current['kind']);
        Config::setLocale($current['lang']);

    } // end function

} // end class
