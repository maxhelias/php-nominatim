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
 * Searches a OSM nominatim service for places.
 *
 * @see http://wiki.openstreetmap.org/wiki/Nominatim
 */
class Search extends Query
{
    /**
     * Constuctor.
     *
     * @param array $query Default value for this query
     */
    public function __construct(array &$query = [])
    {
        parent::__construct($query);

        $this->setPath('search');

        $this->acceptedFormat[] = 'html';
        $this->acceptedFormat[] = 'jsonv2';
    }

    // -- Builder methods ------------------------------------------------------

    /**
     * Query string to search for.
     *
     * @param string $query The query
     *
     * @return \maxh\Nominatim\Search
     */
    public function query(string $query): self
    {
        $this->query['q'] = $query;

        return $this;
    }

    /**
     * Street to search for.
     *
     * Do not combine with query().
     *
     * @param string $street The street
     *
     * @return \maxh\Nominatim\Search
     */
    public function street(string $street): self
    {
        $this->query['street'] = $street;

        return $this;
    }

    /**
     * City to search for (experimental).
     *
     * Do not combine with query().
     *
     * @param string $city The city
     *
     * @return \maxh\Nominatim\Search
     */
    public function city(string $city): self
    {
        $this->query['city'] = $city;

        return $this;
    }

    /**
     * County to search for.
     *
     * Do not combine with query().
     *
     * @param string $county The county
     *
     * @return \maxh\Nominatim\Search
     */
    public function county(string $county): self
    {
        $this->query['county'] = $county;

        return $this;
    }

    /**
     * State to search for.
     *
     * Do not combine with query().
     *
     * @param string $state The state
     *
     * @return \maxh\Nominatim\Search
     */
    public function state(string $state): self
    {
        $this->query['state'] = $state;

        return $this;
    }

    /**
     * Country to search for.
     *
     * Do not combine with query().
     *
     * @param string $country The country
     *
     * @return \maxh\Nominatim\Search
     */
    public function country(string $country): self
    {
        $this->query['country'] = $country;

        return $this;
    }

    /**
     * Postal code to search for (experimental).
     *
     * Do not combine with query().
     *
     * @param string $postalCode The postal code
     *
     * @return \maxh\Nominatim\Search
     */
    public function postalCode(string $postalCode): self
    {
        $this->query['postalcode'] = $postalCode;

        return $this;
    }

    /**
     * Limit search results to a specific country (or a list of countries).
     *
     * <countrycode> should be the ISO 3166-1alpha2 code, e.g. gb for the United
     * Kingdom, de for Germany, etc.
     *
     * @param string $countrycode The country code
     *
     * @throws \maxh\Nominatim\Exceptions\InvalidParameterException if country code is invalid
     *
     * @return \maxh\Nominatim\Search
     */
    public function countryCode(string $countrycode): self
    {
        if (!preg_match('/^[a-z]{2}$/i', $countrycode)) {
            throw new InvalidParameterException("Invalid country code: \"{$countrycode}\"");
        }

        if (empty($this->query['countrycodes'])) {
            $this->query['countrycodes'] = $countrycode;
        } else {
            $this->query['countrycodes'] .= ','.$countrycode;
        }

        return $this;
    }

    /**
     * The preferred area to find search results.
     *
     * @param string $left   Left of the area
     * @param string $top    Top of the area
     * @param string $right  Right of the area
     * @param string $bottom Bottom of the area
     *
     * @return \maxh\Nominatim\Search
     */
    public function viewBox(string $left, string $top, string $right, string $bottom): self
    {
        $this->query['viewbox'] = $left.','.$top.','.$right.','.$bottom;

        return $this;
    }

    /**
     * If you do not want certain OpenStreetMap objects to appear in the search results.
     *
     * @throws \maxh\Nominatim\Exceptions\InvalidParameterException if no place id
     *
     * @return \maxh\Nominatim\Search
     */
    public function exludePlaceIds(): self
    {
        $args = \func_get_args();

        if (\count($args) > 0) {
            $this->query['exclude_place_ids'] = implode(', ', $args);

            return $this;
        }

        throw new InvalidParameterException('No place id in parameter');
    }

    /**
     * Limit the number of returned results.
     *
     * @return \maxh\Nominatim\Search
     */
    public function limit(int $limit): self
    {
        $this->query['limit'] = (string) $limit;

        return $this;
    }
}
