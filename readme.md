testing; stable enough, but may have minor bugs;

### Installation

via Composer:

    composer require streltcov/yandex-geocoder

### Basic usage

Performs request to Yandex Geocoder and provides fluent interface for GeoObject selection


*****

Getting all results found in geocollection:

    <?php
    
    use streltcov\YandexUtils\GeoCoder;

    // returns array of GeoObjects (numeration begins from 0)
    $response = GeoCoder::search($address)->all();
 
*****
 
 Getting single GeoObject:

    <?php
    
    use streltcov\YandexUtils\GeoCoder;
    
    // returns first instance if number is not specified
    $geoobject = GeoCoder::search($address)->one();
    
    // returns GeoObject with specified number (numeration from 0)
    $geoobject = GeoCoder::search($address)->one(1);
    // returns 5 element in geoobjects array
    $response = GeoCoder::search($address)->one(5);
    
    
  *****
  
  Getting GeoObject with exact precision:

    // exact()
    // returns GeoObject with precision property set to exact
    $response = GeoCoder::search($address)->exact();
    

    // searching geocontext with coordinates
    // will return first instance in geoobjects array
    $response = GeoCoder::searchPoint($coordinates)->one();
    
    // parameters:
    // may be set globally by GeoCoder methods setLocality, setKind and SetSkip
    // or in array for single request
    // skip parameter:
    GeoCoder::setSkip(10); // setting globally for all requests
    $response = GeoCoder::search($address)->all(); // will skip first 10 results and return next 10
    $response = GeoCoder::search($address, ['skip' => 10])->all(); // the same for single request
    
    // parameters 'skip' and 'lang' will be used in both cases (searching address or coordinates)
    // parameter 'kind' will be applied only for point coordinates;
    

### Parameters:

Three parameters available - skip, kind and locality

* ##### skip:
    * Normally returns several (up to 10) results with different precision (for example, "exact", "number" or "street" etc.)
* ##### locality:
* ##### kind:

Parameters can be set globally (for all requests) or locally (for single request)

### Public methods

#### GeoCoder:

Static methods:

* ##### search(string $address)
    * search requested address without parameters and returns GeoCollection
* ##### searchPoint(string $coordinates, array $parameters = null)
    * search requested coordinates and returns GeoCollection
    * parameters: 'kind', 'skip', 'lang'
* ##### setLocality(string $locality)
    * sets global language parameter
* ##### setSkip(int $skip)
    * sets global parameter 'skip'
* ##### setKind(string $kind)
    * sets global parameter 'kind' (parameter ignored while requesting address)


*****


#### GeoCollection:

Basic:

* ##### exact()
    * returns GeoObject with "exact" precision (if exists in collection); else returns null
* ##### one(int $index = null)
    * returns GeoObject with requested id (index in array); returns first instance with null parameter
* ##### all()
    * returns array of GeoObjects (numerated from 0)

Geo objects selection fluent interface:

* ##### select(array $parameters)
    * filters geoobjects by kind and/or id (index in array)
* ##### find($substring)
    * filters geoobjects using substring (search matches in GeoObject properties)


*****


#### GeoObject:

* ##### isExact()
    * returns true if current precision is exact; false if not
* ##### getKind()
    * returns string
* ##### getPrecision()
    * returns string
* ##### getName()
    * returns string
* ##### getDescription()
    * returns string
* ##### getAddress()
    * returns string
* ##### getCoordinates()
    * returns string
* ##### getPostalCode()
    * returns string or null
* ##### getCountry()
    * returns string
* ##### getCountryCode()
    * returns string
* ##### getProvince()
    * returns string or null
* ##### getLocality()
    * returns string or null
* ##### getStreet()
    * returns string or null
* ##### getPoint()
    * returns array containing upper and lower corner coordinates
* ##### getData()
    * returns array of geoobject public properties


*****


### Available parameter values:
#### Kinds:
        'house',
        'street',
        'metro',
        'district',
        'locality',
        'province',
        'country',
        'hydro'
        
        (other values will be ignored)

#### Locality:
        'RU' => russian
        'US' => english (american)
        'EN' => english
        'UA' => ukrainian
        'BY' => belorussian
        'TR' => turkish
        
        (other values will be ignored)

### Examples:

    // the following request will set locale to en_US, skip first 5 results, return GeoObjects with kind = metro and
    // select objects with indexes 0, 1 and 2
    $response = GeoCoder::searchPoint($coordinates, ['kind'=> 'metro', 'skip' => 5, 'lang' => 'US'])
    ->select(['id' => [0, 1, 2]])
    ->all();