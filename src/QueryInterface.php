<?php
/**
 * Interface QueryInterce
 *
 * @package      maxh\nominatim
 * @author       Maxime Hélias <maximehelias16@gmail.com>
 */

namespace maxh\Nominatim;

/**
 * QueryInterface for building request to Nominatim 
 */
interface QueryInterface
{
	
	/**
	 * Get path of the request
	 *
	 *  Example request :
	 *  - Search = search
	 *  - Reverse Geocoding = reverse
	 *  
	 * @return string
	 */
	public function getPath();

	/**
	 * Get the query to send
	 * 
	 * @return array
	 */
	public function getQuery();

	/**
	 * Get the format of the request
	 *
	 * Example : json or xml
	 * 
	 * @return string
	 */
	public function getFormat();

}
