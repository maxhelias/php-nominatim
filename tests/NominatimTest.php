<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace maxh\Nominatim\Tests;

use maxh\Nominatim\Details;
use maxh\Nominatim\Lookup;
use maxh\Nominatim\Nominatim;
use maxh\Nominatim\Reverse;
use maxh\Nominatim\Search;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \maxh\Nominatim\Nominatim
 */
final class NominatimTest extends TestCase
{
    protected $url = 'http://nominatim.openstreetmap.org/';

    /**
     * @throws \maxh\Nominatim\Exceptions\NominatimException
     *
     * @covers ::newDetails
     * @covers ::newLookup
     * @covers ::newReverse
     * @covers ::newSearch
     */
    public function testNominatimFactory(): void
    {
        //Instance Nominatim
        $instance = new Nominatim($this->url);
        self::assertInstanceOf(Nominatim::class, $instance);

        //Instance Search
        $search = new Search();
        self::assertInstanceOf(Search::class, $search);

        $baseSearch = $instance->newSearch();
        self::assertEquals($search, $baseSearch);

        //Instance Reverse
        $reverse = new Reverse();
        self::assertInstanceOf(Reverse::class, $reverse);

        $baseReverse = $instance->newReverse();
        self::assertEquals($reverse, $baseReverse);

        //Instance Lookup
        $lookup = new Lookup();
        self::assertInstanceOf(Lookup::class, $lookup);

        $baseLookup = $instance->newLookup();
        self::assertEquals($lookup, $baseLookup);

        //Instance Details
        $details = new Details();
        self::assertInstanceOf(Details::class, $details);

        $baseDetails = $instance->newDetails();
        self::assertEquals($details, $baseDetails);
    }
}
