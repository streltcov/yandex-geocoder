testing; stable enough, but may have minor bugs;

### Usage

Performs request to Yandex Geocoder and provides fluent interface for GeoObject selection

Normally returns several (up to 10) results with
 different precision (for example, "exact", "number" or "street" etc.)


    <?php
    
    use streltcov\YandexUtils\GeoCoder;
    
    // searching address
    // returns array of GeoObjects
    $response = GeoCoder::search($address)->all();
 
 
    // one()
    // returns GeoObject with specified number (numeration from 0)
    // or first instance if number is not specified
    $geoobject = GeoCoder::search($address)->one();
    $geoobject = GeoCoder::search($address)->one(1);
    // returns 5 element in geoobjects array
    $response = GeoCoder::search($address)->one(5);
    

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
    
#### Available languages:
        'RU' => russian
        'US' => english (american)
        'EN' => english
        'UA' => ukrainian
        'BY' => belorussian
        'TR' => turkish
        
        (other values will be ignored)
     
#### Available kinds:

        'house',
        'street',
        'metro',
        'district',
        'locality',
        'province',
        'country',
        'hydro'
        
        (other values will be ignored)
    

### Public methods

#### GeoCoder:

| Static method          | Parameter     | Description |
| --------------- |:-------------:| -----:|
| search($address)| [string] $address | returns GeoCollection|
| searchPoint($coordinates, $parameters) | [string] $coordinates [array] $parameters | searching geocontext via coordinates; returns GeoCollection|
| setLocality($locality)  | [string] $locality | sets global parameter 'locality' |
| setKind($kind)  | [string] $kind | sets global parameter 'kind' (parameter ignored while requesting address) |
| setSkip($skip)  | [integer] $skip | sets global parameter 'skip' |



#### GeoCollection:

| Method          | Parameter     | Description |
| --------------- |:-------------:| -----:|
| exact() | null | returns GeoObject with "exact" precision (if exists in collection); else returns null|
| one() | [integer] | returns GeoObject with requested id (index in array); returns first instance with null parameter|
| all() | null | returns array of GeoObjects |
| select($parameters) | [array] | filters geoobjects by kind and/or id (index in array)|
| find($query) | [string] | filters geoobjects using substring (search matches in GeoObject properties) |


#### GeoObject:

| Method          | Parameter     | Description |
| --------------- |:-------------:| -----:|
| isExact()| [null] | returns true if current precision is exact; false if not|
| getKind() | [null] | returns true if current precision is exact; false if not|
| getPrecision() | [null] | returns current object's precision (string) |
| getName() | [null] | |
| getDescription() | [null] | |
| getAddress() | [null] | |
| getCoordinates() | [null] | |
| getPostalCode() | [null] | |
| getCountry() | [null] | |
| getCountryCode() | [null] | |
| getProvince() | [null] | |
| getLocality() | [null] | |
| getStreet() | [null] | |
| getPoint() | [null] | returns array containing lower and upper corer coordinates |
| getData() | [null] | returns array containing all public GeoObject properties |


### Examples:

    // the following request will set locale to en_US, skip first 5 results, return GeoObjects with kind = metro and
    // select numbers 0, 1 and 2
    $response = GeoCoder::searchPoint($coordinates, ['kind'=> 'metro', 'skip' => 5, 'lang' => 'US'])
    ->select(['id' => [0, 1, 2]])
    ->all();