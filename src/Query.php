<?php
/**
 * Class Query
 *
 * @package      maxh\nominatim
 * @author       Maxime Hélias <maximehelias16@gmail.com>
 */

namespace maxh\Nominatim;

use maxh\Nominatim\Exceptions\InvalidParameterException;

/**
 * Class implementing functionality common to requests nominatim.
 */
class Query implements QueryInterface
{
	/**
	 * Contain the path of the request
	 * @var string
	 */
	protected $path;

	/**
	 * Contain the query for request
	 * @var array
	 */
	protected $query = [];

	/**
	 * Contain the format for decode data returning by the request
	 * @var string
	 */
	protected $format;

	/**
	 * Output format accepted
	 * @var array
	 */
	protected $accepteFormat = ['xml', 'json'];

	/**
	 * Output polygon format accepted
	 * @var array
	 */
	protected $polygon = ['geojson', 'kml', 'svg', 'text'];


	/**
	 * Constuctor
	 * @param array $query Default value for this query
	 */
	public function __construct(array $query = [])
	{
		if (!isset($query['format']))
		{
			//Default format
			$query['format'] = 'json';
		}

		$this->setQuery($query);
		$this->setFormat($query['format']);

	}

	// -- Builder methods ------------------------------------------------------

	/**
	 * Format returning by the request.
	 *
	 * @param  string $format The output format for the request
	 *
	 * @return maxh\Nominatim\Query
	 * @throws maxh\Nominatim\Exceptions\InvalidParameterException if format is not supported
	 */
	public function format($format)
	{
		$format = strtolower($format);

		if (in_array($format, $this->accepteFormat))
		{
			$this->setFormat($format);

			return $this;
		}

		throw new InvalidParameterException("Format is not supported");
	}

	/**
	 * Preferred language order for showing search results, overrides the value
	 * specified in the "Accept-Language" HTTP header. Either uses standard
	 * rfc2616 accept-language string or a simple comma separated list of
	 * language codes.
	 *
	 * @param  string $language         Preferred language order for showing search results, overrides the value specified in the "Accept-Language" HTTP header.
	 * Either uses standard rfc2616 accept-language string or a simple comma separated list of language codes.
	 *
	 * @return maxh\Nominatim\Query
	 */
	public function language($language)
	{
		$this->query['accept-language'] = $language;

		return $this;
	}

	/**
	 * Include a breakdown of the address into elements.
	 *
	 * @param  boolean $details
	 * 
	 * @return maxh\Nominatim\Query
	 */
	public function addressDetails($details = true)
	{
		$this->query['addressdetails'] = $details ? "1" : "0";

		return $this;
	}

	/**
	 * If you are making large numbers of request please include a valid email address or alternatively include your email address as part of the User-Agent string.
	 * This information will be kept confidential and only used to contact you in the event of a problem, see Usage Policy for more details.
	 * 
	 * @param  string $email Address mail
	 * 
	 * @return maxh\Nominatim\Query
	 */
	public function email($email)
	{
		$this->query['email'] = $email;

		return $this;
	}

	/**
	 * Output format for the geometry of results
	 * 
	 * @param  string $polygon
	 * 
	 * @return maxh\Nominatim\Query
	 * @throws maxh\Nominatim\Exceptions\InvalidParameterException  if polygon format is not supported
	 */
	public function polygon($polygon)
	{
		if (in_array($polygon, $this->polygon))
		{
			$this->query['polygon_' . $polygon] = "1";

			return $this;
		}

		throw new InvalidParameterException("This polygon format is not supported");
	}

	/**
	 * Include additional information in the result if available
	 * 
	 * @param  boolean $tags 
	 * 
	 * @return maxh\Nominatim\Query
	 */
	public function extraTags($tags = true)
	{
		$this->query['extratags'] = $tags ? "1" : "0";

		return $this;
	}

	/**
	 * Include a list of alternative names in the results.
	 * These may include language variants, references, operator and brand.
	 * 
	 * @param  boolean $details 
	 * 
	 * @return maxh\Nominatim\Query
	 */
	public function nameDetails($details = true)
	{
		$this->query['namedetails'] = $details ? "1" : "0";

		return $this;
	}

	/**
	 * Returns the URL-encoded query.
	 *
	 * @return string
	 */
	public function getQueryString()
	{
		return http_build_query($this->query);
	}

	// -- Getters & Setters ----------------------------------------------------

	/**
	 * Get path
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Get query
	 * @return array
	 */
	public function getQuery()
	{
		return $this->query;
	}

	/**
	 * Get format
	 * @return string
	 */
	public function getFormat()
	{
		return $this->format;
	}

	/**
	 * Set path
	 * @param string $path Name's path of the service
	 */
	protected function setPath($path)
	{
		$this->path = $path;
	}

	/**
	 * Set query
	 * @param array $query Parameter of the query
	 */
	protected function setQuery($query = array())
	{
		$this->query = $query;
	}

	/**
	 * Set format
	 * @param string $format Format returning by the response
	 */
	protected function setFormat($format)
	{
		$this->format = $this->query['format'] = $format;
	}

}
