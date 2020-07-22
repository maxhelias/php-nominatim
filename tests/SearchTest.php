<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace maxh\Nominatim\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \maxh\Nominatim\Search
 */
final class SearchTest extends TestCase
{
    protected $url = 'http://nominatim.openstreetmap.org/';

    /**
     * Contain url of the current application.
     *
     * @var \maxh\Nominatim\Nominatim
     */
    private $nominatim;

    /**
     * @throws \maxh\Nominatim\Exceptions\NominatimException
     */
    protected function setUp(): void
    {
        $this->nominatim = new \maxh\Nominatim\Nominatim($this->url);
    }

    /**
     * Search HelloWorld.
     *
     * @covers ::getQuery
     * @covers ::getQueryString
     * @covers ::query
     */
    public function testQuery(): void
    {
        /** @var \maxh\Nominatim\Search $search */
        $search = $this->nominatim->newSearch()
            ->query('HelloWorld')
        ;

        $expected = [
            'format' => 'json',
            'q' => 'HelloWorld',
        ];

        $query = $search->getQuery();
        self::assertSame($expected, $query);

        $expected = http_build_query($query);
        self::assertSame($expected, $search->getQueryString());
    }

    /**
     * @covers ::addressDetails
     * @covers ::city
     * @covers ::country
     * @covers ::getQuery
     * @covers ::getQueryString
     * @covers ::postalCode
     */
    public function testAddress(): void
    {
        $search = $this->nominatim->newSearch()
            ->country('France')
            ->city('Bayonne')
            ->postalCode('64100')
            ->addressDetails()
        ;

        $expected = [
            'format' => 'json',
            'country' => 'France',
            'city' => 'Bayonne',
            'postalcode' => '64100',
            'addressdetails' => '1',
        ];

        $query = $search->getQuery();
        self::assertSame($expected, $query);

        $expected = http_build_query($query);
        self::assertSame($expected, $search->getQueryString());
    }
}
