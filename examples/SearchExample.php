<?php

require '../vendor/autoload.php';

use maxh\Nominatim\Nominatim;

//URL Server
$url = "http://nominatim.openstreetmap.org/";

$instance = new Nominatim($url);

$Search = $instance->newSearch()
			->country('France')
			->city('Bayonne')
			->postalCode('64100')
			->polygon('geojson')
			->addressDetails();

$result = $instance->find($Search);

echo 'URL : ' . $url . $Search->getPath() . '?'. $Search->getQueryString();


var_dump($result);