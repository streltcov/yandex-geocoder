in progress

### Usage

Implements fluent interface and works closely similar to database query builders

Normally Yandex-Geocoder returns several (up to 10) results with
 different precision (for example, "exact", "number" or "street" etc.)


    <?php
    
    use streltcov\YandexGeocoder;
    
    // searching address
    // returns array of GeoObjects
    $response = GeoCoder::search($address)->all();
    
    // method one()
    // returns first instance from geoobjects array
    $response = GeoCoder::search($address)->one();
    
    // method one()
    // returns 5 element in geoobjects array
    $response = GeoCoder::search($address)->one(5);
    
    // returns GeoObject with precision property set to exact
    $response = GeoCoder::search($address)->exact();
    
    // searching geocontext with coordinates
    // will return first instance in geoobjects array
    $response = GeoCoder::searchPoint($coordinates)->one();

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