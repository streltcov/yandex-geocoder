<?php

namespace streltcov\geocoder;

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

class ErrorObject extends GeoObject
{

    public function __construct()
    {
        //parent::__construct($geoobject);
        $error_message = 'Error, no results found; please, check requested data';
        $this->description = $error_message;
        $this->name = $error_message;
        $this->envelope = $error_message;
        $this->precision = 'exact';
        $this->metadata = $error_message;

    } // end construct

} // end class