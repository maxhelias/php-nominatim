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
 * Reverse Geocoding a OSM nominatim service for places.
 *
 * @see http://wiki.openstreetmap.org/wiki/Nominatim
 */
class Reverse extends Query
{
    /**
     * OSM Type accepted (Node/Way/Relation).
     *
     * @var array
     */
    public $osmType = ['N', 'W', 'R'];

    /**
     * Constructor.
     *
     * @param array $query Default value for this query
     */
    public function __construct(array &$query = [])
    {
        parent::__construct($query);

        $this->setPath('reverse');
    }

    // -- Builder methods ------------------------------------------------------

    /**
     * [osmType description].
     *
     * @throws \maxh\Nominatim\Exceptions\InvalidParameterException if osm type is not supported
     *
     * @return \maxh\Nominatim\Reverse
     */
    public function osmType(string $type): self
    {
        if (\in_array($type, $this->osmType, true)) {
            $this->query['osm_type'] = $type;

            return $this;
        }

        throw new InvalidParameterException('OSM Type is not supported');
    }

    /**
     * A specific osm node / way / relation to return an address for.
     *
     * @return \maxh\Nominatim\Reverse
     */
    public function osmId(int $id): self
    {
        $this->query['osm_id'] = $id;

        return $this;
    }

    /**
     * The location to generate an address for.
     *
     * @param float $lat The latitude
     * @param float $lon The longitude
     *
     * @return \maxh\Nominatim\Reverse
     */
    public function latlon(float $lat, float $lon): self
    {
        $this->query['lat'] = $lat;

        $this->query['lon'] = $lon;

        return $this;
    }

    /**
     * Level of detail required where 0 is country and 18 is house/building.
     *
     * @return \maxh\Nominatim\Reverse
     */
    public function zoom(int $zoom): self
    {
        $this->query['zoom'] = (string) $zoom;

        return $this;
    }
}
