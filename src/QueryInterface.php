<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace maxh\Nominatim;

/**
 * QueryInterface for building request to Nominatim.
 */
interface QueryInterface
{
    /**
     * Get path of the request.
     *
     *  Example request :
     *  - Search = search
     *  - Reverse Geocoding = reverse
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Get the query to send.
     *
     * @return array
     */
    public function getQuery(): array;

    /**
     * Get the format of the request.
     *
     * Example : json or xml
     *
     * @return string
     */
    public function getFormat(): string;
}
