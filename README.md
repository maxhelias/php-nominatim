Wrapper Nominatim API
================

A simple interface to OSM Nominatim.


See [Nominatim documentation](http://wiki.openstreetmap.org/wiki/Nominatim) for info on the service.

Basic usage
-----------

Create a new instance of Nominatim.

```php
use maxh\Nominatim\Nominatim;

$url = "http://nominatim.openstreetmap.org/";
$nominatim = new Nominatim($url);
```

Searching by query :

```php
$search = $nominatim->newSearch();
$search->query('HelloWorld');

$nominatim->find($search);
```

Or break it down by address :

```php
$search = $nominatim->newSearch()
            ->country('France')
            ->city('Bayonne')
            ->postalCode('64100')
            ->polygon('geojson')    //or 'kml', 'svg' and 'text'
            ->addressDetails();

$result = $nominatim->find($search);
```

Or do a reverse query :

```php
$reverse = $nominatim->newReverse()
            ->latlon(43.4843941, -1.4960842);

$result = $nominatim->find($reverse);
```


By default, the output format of the request is json and the wrapper return a array of results. 
It can be also xml, but the wrapper return a object [SimpleXMLElement](http://php.net/manual/fr/simplexml.examples-basic.php)
