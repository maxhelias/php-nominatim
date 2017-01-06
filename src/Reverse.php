<?php
/**
 * Class Reverse
 *
 * @package      maxh\nominatim
 * @author       Maxime Hélias <maximehelias16@gmail.com>
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
	 * OSM Type accepted (Node/Way/Relation)
	 * @var array
	 */
	public $osmType = ['N', 'W', 'R'];


	/**
	 * Constructo
	 * @param array $query Default value for this query
	 */
	public function __construct(array $query = [])
	{
		parent::__construct();

		$this->setPath('reverse');
	}

	// -- Builder methods ------------------------------------------------------

	/**
	 * [osmType description]
	 * 
	 * @param  string $type
	 * 
	 * @return maxh\Nominatim\Reverse
	 * @throws maxh\Nominatim\Exceptions\InvalidParameterException  if osm type is not supported
	 */
	public function osmType($type)
	{
		if (in_array($type, $this->osmType))
		{
			$this->query['osm_type'] = $type;

			return $this;
		}

		throw new InvalidParameterException("OSM Type is not supported");

	}

	/**
	 * A specific osm node / way / relation to return an address for.
	 * 
	 * @param  integer $id
	 * 
	 * @return maxh\Nominatim\Reverse
	 */
	public function osmId($id)
	{
		$this->query['osm_id'] = $id;

		return $this;
	}

	/**
	 * The location to generate an address for
	 * 
	 * @param  float $lat The latitude
	 * @param  float $lon The longitude
	 * 
	 * @return maxh\Nominatim\Reverse
	 */
	public function latlon($lat, $lon)
	{
		$this->query['lat'] = $lat;

		$this->query['lon'] = $lon;

		return $this;
	}

	/**
	 * Level of detail required where 0 is country and 18 is house/building
	 * 
	 * @param  integer $zoom 
	 * 
	 * @return maxh\Nominatim\Reverse
	 */
	public function zoom($zoom)
	{
		$this->query['zoom'] = strval($zoom);

		return $this;
	}


}
