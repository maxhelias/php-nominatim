<?php

require '../vendor/autoload.php';

use maxh\Nominatim\Nominatim;

//URL Server
$url = "http://nominatim.openstreetmap.org/";

$instance = new Nominatim($url);

$Reverse = $instance->newReverse()
			->latlon(43.4843941, -1.4960842);

$result = $instance->find($Reverse);

echo 'URL : ' . $url . $Reverse->getQueryString();

var_dump($result);