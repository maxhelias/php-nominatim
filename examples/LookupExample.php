<?php

require '../vendor/autoload.php';

use maxh\Nominatim\Nominatim;

//URL Server
$url = "http://nominatim.openstreetmap.org/";

$instance = new Nominatim($url);

$Lookup = $instance->newLookup()
			->format('xml')
			->osmIds('R146656,W104393803,N240109189')
			->nameDetails(true);

$result = $instance->find($Lookup);

echo 'URL : ' . $url . $Lookup->getPath() . '?'. $Lookup->getQueryString();


var_dump($result);