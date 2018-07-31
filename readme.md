in progress


### Public methods:
### GeoCoder
* search($address) - return GeoData object (Search by address)
* searchContext($coordinates, $kind) - returns Context object (search by coordinates)
    * $coordinates - required parameter 
    * $kind - optional parameter
* setLocale($lang) - sets response locale (see available languages)

### GeoData
* getExact() - return GeoObject, containing exact location (if exists, else will return first instance in geoobjects collection)
* isExact() - checks if exact location exists in response

### GeoObject
* getDescription()
* getName()
* getCoordinates()
* getCountryCode()
* getPostalCode()
* getPoint()
