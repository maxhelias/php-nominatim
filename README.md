Wrapper Nominatim API
================

[![Build Status](https://travis-ci.org/maxhelias/php-nominatim.svg?branch=master)](https://travis-ci.org/maxhelias/php-nominatim)
[![Join the chat at https://gitter.im/maxhelias/php-nominatim](https://badges.gitter.im/maxhelias-php-nominatim/Lobby.svg)](https://gitter.im/maxhelias/php-nominatim?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/maxhelias/php-nominatim/blob/master/LICENSE)

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

How to customize HTTP client configuration?
-------------------------------------------

You can inject your own HTTP client with your specific configuration. For instance, you can edit user-agent and timeout for all your requests

```php
<?php
use maxh\Nominatim\Nominatim;
use GuzzleHttp\Client;

$client = new Client();
$client->setDefaultOption('timeout', 1);
$client->setDefaultOption('headers', array('User-Agent' => 'api_client') );

$url = "http://nominatim.openstreetmap.org/";
$nominatim = new Nominatim($url, $client);

?>
```