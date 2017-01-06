<?php
/**
 * Class Search
 *
 * @package      maxh\nominatim
 * @author       Maxime Hélias <maximehelias16@gmail.com>
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
	 * Constuctor
	 * @param array $query Default value for this query
	 */
	public function __construct(array $query = [])
	{
		parent::__construct();

		$this->setPath('search');

		$this->accepteFormat[] = 'html';
		$this->accepteFormat[] = 'jsonv2';
	}

	// -- Builder methods ------------------------------------------------------

	/**
	 * Query string to search for.
	 *
	 * @param  string $query The query
	 *
	 * @return maxh\Nominatim\Search
	 */
	public function query($query)
	{
		$this->query['q'] = $query;

		return $this;
	}

	/**
	 * Street to search for.
	 *
	 * Do not combine with query().
	 *
	 * @param  string $street The street
	 *
	 * @return maxh\Nominatim\Search
	 */
	public function street($street)
	{
		$this->query['street'] = $street;

		return $this;
	}

	/**
	 * City to search for (experimental).
	 *
	 * Do not combine with query().
	 * 
	 * @param  string $city The city
	 *
	 * @return maxh\Nominatim\Search
	 */
	public function city($city)
	{
		$this->query['city'] = $city;

		return $this;
	}

	/**
	 * County to search for.
	 *
	 * Do not combine with query().
	 * 
	 * @param  string $county The county
	 *
	 * @return maxh\Nominatim\Search
	 */
	public function county($county)
	{
		$this->query['county'] = $county;

		return $this;
	}

	/**
	 * State to search for.
	 *
	 * Do not combine with query().
	 *
	 * @param  string $state The state
	 *
	 * @return maxh\Nominatim\Search
	 */
	public function state($state)
	{
		$this->query['state'] = $state;

		return $this;
	}

	/**
	 * Country to search for.
	 *
	 * Do not combine with query().
	 *
	 * @param  string $country The country
	 *
	 * @return maxh\Nominatim\Search
	 */
	public function country($country)
	{
		$this->query['country'] = $country;

		return $this;
	}

	/**
	 * Postal code to search for (experimental).
	 *
	 * Do not combine with query().
	 *
	 * @param  integer $postalCode The postal code
	 *
	 * @return maxh\Nominatim\Search
	 */
	public function postalCode($postalCode)
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
	 * @param  string $countrycode The country code
	 *
	 * @return maxh\Nominatim\Search
	 * @throws maxh\Nominatim\Exceptions\InvalidParameterException if country code is invalid
	 */
	public function countryCode($countrycode)
	{
		if (!preg_match('/^[a-z]{2}$/i', $countrycode)) {
			throw new InvalidParameterException("Invalid country code: \"$countrycode\"");
		}

		if (!isset($this->query['countrycode'])) {
			$this->query['countrycode'] = $countrycode;
		} else {
			$this->query['countrycode'] .= "," . $countrycode;
		}

		return $this;
	}

	/**
	 * The preferred area to find search results
	 * 
	 * @param  string $left   Left of the area
	 * @param  string $top	Top of the area
	 * @param  string $right  Right of the area
	 * @param  string $bottom Bottom of the area
	 * 
	 * @return maxh\Nominatim\Search
	 */
	public function viewBox($left, $top, $right, $bottom)
	{
		$this->query['viewbox'] = $left . ',' . $top . ',' . $right . ',' . $bottom;

		return $this;
	}

	/**
	 * If you do not want certain openstreetmap objects to appear in the search results.
	 * 
	 * @return maxh\Nominatim\Search
	 * @throws maxh\Nominatim\Exceptions\InvalidParameterException  if no place id
	 */
	public function exludePlaceIds()
	{
		$args = func_get_args();

		if (count($args) > 0)
		{
			$this->query['exclude_place_ids'] = implode(', ', $args);

			return $this;
		}

		throw new InvalidParameterException("No place id in parameter");
	}

	/**
	 * Limit the number of returned results
	 * 
	 * @param  integer $limit 
	 * 
	 * @return maxh\Nominatim\Search
	 */
	public function limit($limit)
	{
		$this->query['limit'] = strval($limit);

		return $this;
	}


}
