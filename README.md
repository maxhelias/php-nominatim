Wrapper Nominatim API
================

[![Latest Stable Version](https://poser.pugx.org/maxh/php-nominatim/v/stable)](https://packagist.org/packages/maxh/php-nominatim)
[![Build Status](https://travis-ci.com/maxhelias/php-nominatim.svg?branch=master)](https://travis-ci.com/maxhelias/php-nominatim)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maxhelias/php-nominatim/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maxhelias/php-nominatim/?branch=master)
[![Total Downloads](https://poser.pugx.org/maxh/php-nominatim/downloads)](https://packagist.org/packages/maxh/php-nominatim)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/maxhelias/php-nominatim/blob/master/LICENSE)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c54e5519-01fd-4855-980f-3a28c5f6ff12/big.png)](https://insight.sensiolabs.com/projects/c54e5519-01fd-4855-980f-3a28c5f6ff12)

A simple interface to OSM Nominatim.


See [Nominatim documentation](http://wiki.openstreetmap.org/wiki/Nominatim) for info on the service.

Installation
------------

Install the package through [composer](http://getcomposer.org):

```bash
composer require maxh/php-nominatim
```

Make sure, that you include the composer [autoloader](https://getcomposer.org/doc/01-basic-usage.md#autoloading)
somewhere in your codebase.

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

Or do a lookup query :

```php
$lookup = $nominatim->newLookup()
            ->format('xml')
            ->osmIds('R146656,W104393803,N240109189')
            ->nameDetails(true);

$result = $nominatim->find($lookup);
```

Or do a details query (by place_id):

```php
$details = $nominatim->newDetails()
            ->placeId(1234)
            ->polygon('geojson');

$result = $nominatim->find($details);
```

Or do a details query (by osm type and osm id):

```php
$details = $nominatim->newDetails()
            ->osmType('R')
            ->osmId(1234)
            ->polygon('geojson');

$result = $nominatim->find($details);
```

By default, the output format of the request is json and the wrapper return a array of results. 
It can be also xml, but the wrapper return a object [SimpleXMLElement](http://php.net/manual/fr/simplexml.examples-basic.php)

How to override request header ?
--------------------------------

There are two possibilities :

1. By `Nominatim` instance, for all request :
```php
$nominatim = new Nominatim($url, [
    'verify' => false
]);
```
2. By `find` method, for a request :
````php
$result = $nominatim->find($lookup, [
    'verify' => false
]);
````

How to customize HTTP client configuration ?
--------------------------------------------

You can inject your own HTTP client with your specific configuration. For instance, you can edit user-agent and timeout for all your requests

```php
<?php
use maxh\Nominatim\Nominatim;
use GuzzleHttp\Client;

$url = "http://nominatim.openstreetmap.org/";
$defaultHeader = [
    'verify' => false,
    'headers', array('User-Agent' => 'api_client')
];

$client = new Client([
    'base_uri'           => $url,
    'timeout'            => 30,
    'connection_timeout' => 5,
]);

$nominatim = new Nominatim($url, $defaultHeader, $client);
```

Note
----

This projet was inpired by the [Opendi/nominatim](https://github.com/opendi/nominatim) project with more features like reverse query, support of the xml format, customize HTTP client and more on which i work.

Recall Usage Policy Nominatim 
-----------------------------

If you use the service : [http://nominatim.openstreetmap.org/](http://nominatim.openstreetmap.org/), please see [Nominatim usage policy](http://wiki.openstreetmap.org/wiki/Nominatim_usage_policy).
