<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require '../vendor/autoload.php';

use maxh\Nominatim\Nominatim;

//URL Server
$url = 'http://nominatim.openstreetmap.org/';

try {
    $instance = new Nominatim($url);

    $lookup = $instance->newLookup()
        ->osmIds('R146656,W104393803,N240109189')
        ->nameDetails(true)
        ->format('xml');

    $result = $instance->find($lookup);

    echo 'URL : ' . $url . $lookup->getPath() . '?' . $lookup->getQueryString();

    \var_dump($result);
} catch (\maxh\Nominatim\Exceptions\InvalidParameterException $e) {
    // If you set invalid parameter in instance
    \var_dump($e->getMessage());
} catch (\GuzzleHttp\Exception\ClientException $e) {
    // If you have any exceptions with Guzzle
    \var_dump($e->getMessage());
} catch (\maxh\Nominatim\Exceptions\NominatimException $e) {
    // If you set a wrong instance of Nominatim
    \var_dump($e->getMessage());
}
