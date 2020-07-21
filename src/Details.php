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
 * Lookup details about a single place by id.
 *
 * @see http://wiki.openstreetmap.org/wiki/Nominatim
 */
class Details extends Query
{
    /**
     * Constructor.
     *
     * @param array $query Default value for this query
     */
    public function __construct(array &$query = [])
    {
        parent::__construct($query);

        $this->setPath('details');

        $this->acceptedFormat[] = 'html';
        $this->acceptedFormat[] = 'jsonv2';
    }

    /**
     * Place information by placeId.
     *
     * @return Details
     */
    public function placeId(int $placeId): self
    {
        $this->query['place_id'] = $placeId;

        return $this;
    }

    /**
     * Place information by osmtype and osmid.
     *
     * @return Details
     */
    public function osmId(string $osmType, int $osmId): self
    {
        $this->query['osmtype'] = $osmType;
        $this->query['osmid'] = $osmId;

        return $this;
    }
}
