<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require '../vendor/autoload.php';

use maxh\Nominatim\Consts;
use maxh\Nominatim\Nominatim;

//URL Server
$url = 'http://nominatim.openstreetmap.org/';

try {
    $instance = new Nominatim($url, [
        'verify' => false,
    ]);

    //Details by placeid
    $details = $instance->newDetails()
        ->placeId(235563716)
        ->polygon('geojson')
    ;

    $result = $instance->find($details);

    echo "Details by place_id\n";
    echo 'URL : '.$url.$details->getPath().'?'.$details->getQueryString()."\n";

    var_dump($result);

    //Details by osm type and osm id
    $details = $instance->newDetails()
        ->osmId(Consts\OsmTypes::RELATIVE, 2555133)
    ;

    $result = $instance->find($details);

    echo "Details by osm type and osm id\n";
    echo 'URL : '.$url.$details->getPath().'?'.$details->getQueryString()."\n";

    var_dump($result);
} catch (\maxh\Nominatim\Exceptions\InvalidParameterException $e) {
    // If you set invalid parameter in instance
    var_dump($e->getMessage());
} catch (\GuzzleHttp\Exception\ClientException $e) {
    // If you have any exceptions with Guzzle
    var_dump($e->getMessage());
} catch (\maxh\Nominatim\Exceptions\NominatimException $e) {
    // If you set a wrong instance of Nominatim
    var_dump($e->getMessage());
}
