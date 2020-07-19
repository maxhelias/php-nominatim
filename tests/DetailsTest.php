<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace maxh\Nominatim\Test;

use maxh\Nominatim\Exceptions\InvalidParameterException;

class DetailsTest extends \PHPUnit\Framework\TestCase
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
    protected function setUp()
    {
        $this->nominatim = new \maxh\Nominatim\Nominatim($this->url);
    }

    /**
     * Details for place with id 1234.
     */
    public function testPlaceId()
    {
        /** @var \maxh\Nominatim\Details $details */
        $details = $this->nominatim->newDetails()
            ->placeId(1234);

        $expected = [
            'format'   => 'json',
            'place_id' => 1234,
        ];

        $query = $details->getQuery();
        $this->assertSame($expected, $query);

        $expected = \http_build_query($query);
        $this->assertSame($expected, $details->getQueryString());
    }

    /**
     * Details by osmtype and osmid.
     *
     * @dataProvider osmIdProvider
     *
     * @param $assertException
     *
     * @throws InvalidParameterException
     */
    public function testOsmId(string $osmType, int $osmId, $assertException)
    {
        if ($assertException) {
            $this->expectException($assertException);
        }

        /** @var \maxh\Nominatim\Details $details */
        $details = $this->nominatim->newDetails()
            ->osmId($osmType, $osmId);

        if (!$assertException) {
            $expected = [
                'format'  => 'json',
                'osmtype' => $osmType,
                'osmid'   => $osmId,
            ];

            $query = $details->getQuery();
            $this->assertSame($expected, $query);

            $expected = \http_build_query($query);
            $this->assertSame($expected, $details->getQueryString());
        }
    }

    /**
     * Provider for testOsmId method.
     */
    public function osmIdProvider(): array
    {
        return [
            //OsmType, OsmId, AssertException
            ['W', 1234, null], //W1234
            ['N', 1221, null], //N1221
            ['R', 43534, null], //R43534
            ['X', 43534, InvalidParameterException::class], //X43534 (Invalid)
        ];
    }
}
