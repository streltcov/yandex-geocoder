in progress

### Usage

Works closely similar to database query builders

Normally Yandex-Geocoder returns several (up to 10) results with
 different precision (for example, "exact" or "number" or "street" etc.)


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
    $response = GeoCoder::searchContext($coordinates)->one();

### Public methods

#### GeoCoder:

| Static method          | Parameter     | Description |
| --------------- |:-------------:| -----:|
| search($address)| [string] $address | returns GeoData object|
| searchContext($coordinates) | [string] $coordinates | returns ContextObject |
| setLocality()  | [string] $locality | sets global parameter 'locality' |



#### Response object (GeoData or ContextData):

| Method          | Parameter     |   |
| --------------- |:-------------:| -----:|
| exact() | null | |
| one() | [integer] | |
| all() | null | |
| select($parameters) | [array] | |
| except($parameters) | [array] | |