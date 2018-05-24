<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace maxh\Nominatim\Test;

use maxh\Nominatim\Lookup;
use maxh\Nominatim\Nominatim;
use maxh\Nominatim\Reverse;
use maxh\Nominatim\Search;

class NominatimTest extends \PHPUnit\Framework\TestCase
{
    protected $url = 'http://nominatim.openstreetmap.org/';

    /**
     * @throws \maxh\Nominatim\Exceptions\NominatimException
     */
    public function testNominatimFactory()
    {
        //Instance Nominatim
        $instance = new Nominatim($this->url);
        $this->assertInstanceOf(Nominatim::class, $instance);

        //Instance Search
        $search = new Search();
        $this->assertInstanceOf(Search::class, $search);

        $baseSearch = $instance->newSearch();
        $this->assertEquals($search, $baseSearch);

        //Instance Reverse
        $reverse = new Reverse();
        $this->assertInstanceOf(Reverse::class, $reverse);

        $baseReverse = $instance->newReverse();
        $this->assertEquals($reverse, $baseReverse);

        //Instance Lookup
        $lookup = new Lookup();
        $this->assertInstanceOf(Lookup::class, $lookup);

        $baseLookup = $instance->newLookup();
        $this->assertEquals($lookup, $baseLookup);
    }
}
