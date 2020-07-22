<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace maxh\Nominatim;

use maxh\Nominatim\Exceptions\InvalidParameterException;

/**
 * Lookup the address of one or multiple OSM objects like node, way or relation.
 *
 * @see http://wiki.openstreetmap.org/wiki/Nominatim
 */
class Lookup extends Query
{
    /**
     * Constuctor.
     *
     * @param array $query Default value for this query
     */
    public function __construct(array &$query = [])
    {
        parent::__construct($query);

        $this->setPath('lookup');
    }

    // -- Builder methods ------------------------------------------------------

    /**
     * A list of up to 50 specific osm node, way or relations ids to return the addresses for.
     *
     * @return \maxh\Nominatim\Lookup
     */
    public function osmIds(string $id): self
    {
        $this->query['osm_ids'] = $id;

        return $this;
    }

    /**
     * Output format for the geometry of results.
     *
     * @throws \maxh\Nominatim\Exceptions\InvalidParameterException Polygon is not supported with lookup
     */
    public function polygon(string $polygon): void
    {
        throw new InvalidParameterException('The polygon is not supported with lookup');
    }
}
