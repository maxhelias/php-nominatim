<?php
/**
 * Class Nominatim
 *
 * @package      maxh\nominatim
 * @author       Maxime Hélias <maximehelias16@gmail.com>
 */

namespace maxh\Nominatim;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

use maxh\Nominatim\Exceptions\InvalidParameterException;
use maxh\Nominatim\Exceptions\NominatimException;

/**
 *  Wrapper to manage exchanges with OSM Nominatim API
 *  
 */
class Nominatim
{

	/**
	 * Contain url of the current application
	 * @var string
	 */
	private $application_url = null;

	/**
	 * Contain http client connection
	 * @var Client
	 */
	private $http_client = null;

	/**
	 * The search object which serves as a template for new ones created
	 * by 'newSearch()' method.
	 *
	 * @var Search
	 */
	private $baseSearch;

	/**
	 * Template for new ones created by 'newReverser()' method.
	 * @var Reverse
	 */
	private $baseReverse;

	/**
	 * Template for new ones created by 'newLookup()' method.
	 * @var Lookup
	 */
	private $baseLookup;

	/**
	 * Constructor
	 * @param string      			$application_url Contain url of the current application
	 * @param Guzzle\Client|null 	$http_client     Client object from Guzzle
	 */
	public function __construct(
		$application_url,
		Client $http_client = null
	) {

		if (!isset($application_url))
		{
			throw new InvalidParameterException("Application url parameter is empty");
		}

		if (!isset($http_client))
		{
			$http_client = new Client([
				'base_uri'			 => $application_url,
				'timeout'			 => 30,
				'connection_timeout' => 5,
			]);
		} else if ($http_client instanceof Client)
		{
			$application_url_client = $http_client->getConfig('base_uri');

			if (!isset($application_url_client))
			{
				$http_client->setDefaultOption('base_uri', $application_url);
			} else if ($application_url_client != $application_url)
			{
				throw new InvalidParameterException("http_client parameter has a differente url to application_url parameter");
			}
		} else
		{
			throw new InvalidParameterException("http_client parameter must be a GuzzleHttp\Client object or empty");
		}

		$this->application_url = $application_url;
		$this->http_client = $http_client;

		//Create base
		$this->baseSearch = new Search();
		$this->baseReverse = new Reverse();
		$this->baseLookup = new Lookup();

	}

	/**
	 * Returns a new search object based on the base search.
	 *
	 * @return Search
	 */
	public function newSearch()
	{
		return clone $this->baseSearch;
	}

	/**
	 * Returns a new search object based on the base reverse.
	 *
	 * @return Reverse
	 */
	public function newReverse()
	{
		return clone $this->baseReverse;
	}

	/**
	 * Returns a new search object based on the base lookup.
	 * 
	 * @return Lookup
	 */
	public function newLookup()
	{
		return clone $this->baseLookup;
	}

	/**
	 * Decode the data returned from the request
	 * 
	 * @param  string   $format   json or xml
	 * @param  Request  $request  Request object from Guzzle
	 * @param  ResponseInterface $response Interface response object from Guzzle
	 * 
	 * @return array|\SimpleXMLElement
	 * @throws maxh\Nominatim\Exceptions\NominatimException if no format for decode
	 */
	private function decodeResponse($format, Request $request, ResponseInterface $response)
	{

		if ($format == 'json')
		{
			return json_decode($response->getBody(), true);
		}

		if ($format == 'xml')
		{
			return new \SimpleXMLElement($response->getBody());
		}

		throw new NominatimException("Format is undefined or not supported for decode response", $request, $response);
	}

	/**
	 * Runs the query and returns the result set from Nominatim.
	 * @param  QueryInterface $nRequest  The object request to send
	 * 
	 * @return array                                        The decoded data returned from Nominatim
	 * @throws \GuzzleHttp\Exception\ClientException 		if http request is an error
	 */
	public function find(QueryInterface $nRequest)
	{
		$url = $this->application_url . '/' . $nRequest->getPath() . '?';
		$request = new Request('GET', $url);

		//Convert the query array to string with space replace to +
		$query = \GuzzleHttp\Psr7\build_query($nRequest->getQuery(), PHP_QUERY_RFC1738);

		$url = $request->getUri()->withQuery($query);
		$request = $request->withUri($url);

		return $this->decodeResponse(
			$nRequest->getFormat(),
			$request,
			$this->http_client->send($request)
		);
	}

	/**
	 * Return the client using by instance
	 * @return GuzzleHttp\Client
	 */
	public function getClient()
	{
		return $this->http_client;
	}

}
