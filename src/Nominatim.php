<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace maxh\Nominatim;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use maxh\Nominatim\Exceptions\NominatimException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use SimpleXMLElement;

/**
 *  Wrapper to manage exchanges with OSM Nominatim API.
 *
 * @see http://wiki.openstreetmap.org/wiki/Nominatim
 */
class Nominatim
{
    /**
     * Contain url of the current application.
     *
     * @var string
     */
    private $application_url;

    /**
     * Contain default request headers.
     *
     * @var array
     */
    private $defaultHeaders;

    /**
     * Contain http client connection.
     *
     * @var \GuzzleHttp\Client
     */
    private $http_client;

    /**
     * The search object which serves as a template for new ones created
     * by 'newSearch()' method.
     *
     * @var \maxh\Nominatim\Search
     */
    private $baseSearch;

    /**
     * Template for new ones created by 'newReverser()' method.
     *
     * @var \maxh\Nominatim\Reverse
     */
    private $baseReverse;

    /**
     * Template for new ones created by 'newLookup()' method.
     *
     * @var \maxh\Nominatim\Lookup
     */
    private $baseLookup;

    /**
     * Template for new ones created by 'newDetails()' method.
     *
     * @var \maxh\Nominatim\Lookup
     */
    private $baseDetails;

    /**
     * Constructor.
     *
     * @param string                  $application_url Contain url of the current application
     * @param null|\GuzzleHttp\Client $http_client     Client object from Guzzle
     * @param array                   $defaultHeaders  Define default header for all request
     *
     * @throws NominatimException
     */
    public function __construct(
        string $application_url,
        array $defaultHeaders = [],
        ?Client $http_client = null
    ) {
        if (empty($application_url)) {
            throw new NominatimException('Application url parameter is empty');
        }

        if (null === $http_client) {
            $http_client = new Client([
                'base_uri' => $application_url,
                'timeout' => 30,
                'connection_timeout' => 5,
            ]);
        } elseif ($http_client instanceof Client) {
            $application_url_client = (string) $http_client->getConfig('base_uri');

            if (empty($application_url_client)) {
                throw new NominatimException('http_client must have a configured base_uri.');
            }

            if ($application_url_client !== $application_url) {
                throw new NominatimException('http_client parameter hasn\'t the same url application.');
            }
        } else {
            throw new NominatimException('http_client parameter must be a \\GuzzleHttp\\Client object or empty');
        }

        $this->application_url = $application_url;
        $this->defaultHeaders = $defaultHeaders;
        $this->http_client = $http_client;

        //Create base
        $this->baseSearch = new Search();
        $this->baseReverse = new Reverse();
        $this->baseLookup = new Lookup();
        $this->baseDetails = new Details();
    }

    /**
     * Returns a new search object based on the base search.
     *
     * @return \maxh\Nominatim\Search
     */
    public function newSearch(): Search
    {
        return clone $this->baseSearch;
    }

    /**
     * Returns a new reverse object based on the base reverse.
     *
     * @return \maxh\Nominatim\Reverse
     */
    public function newReverse(): Reverse
    {
        return clone $this->baseReverse;
    }

    /**
     * Returns a new lookup object based on the base lookup.
     *
     * @return \maxh\Nominatim\Lookup
     */
    public function newLookup(): Lookup
    {
        return clone $this->baseLookup;
    }

    /**
     * Returns a new datails object based on the base details.
     *
     * @return \maxh\Nominatim\Details
     */
    public function newDetails(): Details
    {
        return clone $this->baseDetails;
    }

    /**
     * Runs the query and returns the result set from Nominatim.
     *
     * @param QueryInterface $nRequest The object request to send
     * @param array          $headers  Override the request header
     *
     * @throws NominatimException                    if no format for decode
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return array|SimpleXMLElement The decoded data returned from Nominatim
     */
    public function find(QueryInterface $nRequest, array $headers = [])
    {
        $url = $this->application_url.'/'.$nRequest->getPath().'?';
        $request = new Request('GET', $url, array_merge($this->defaultHeaders, $headers));

        //Convert the query array to string with space replace to +
        if (method_exists(\GuzzleHttp\Psr7\Query::class, 'build')) {
            $query = \GuzzleHttp\Psr7\Query::build($nRequest->getQuery(), PHP_QUERY_RFC1738);
        } else {
            $query = \GuzzleHttp\Psr7\build_query($nRequest->getQuery(), PHP_QUERY_RFC1738);
        }

        $url = $request->getUri()->withQuery($query);
        $request = $request->withUri($url);

        return $this->decodeResponse(
            $nRequest->getFormat(),
            $request,
            $this->http_client->send($request)
        );
    }

    /**
     * Return the client using by instance.
     */
    public function getClient(): Client
    {
        return $this->http_client;
    }

    /**
     * Decode the data returned from the request.
     *
     * @param string            $format   json or xml
     * @param RequestInterface  $request  Request object from Guzzle
     * @param ResponseInterface $response Interface response object from Guzzle
     *
     * @throws RuntimeException
     * @throws \maxh\Nominatim\Exceptions\NominatimException if no format for decode
     *
     * @return array|SimpleXMLElement
     */
    private function decodeResponse(string $format, RequestInterface $request, ResponseInterface $response)
    {
        if ('json' === $format || 'jsonv2' === $format || 'geojson' === $format || 'geocodejson' === $format) {
            return json_decode($response->getBody()->getContents(), true);
        }

        if ('xml' === $format) {
            return new SimpleXMLElement($response->getBody()->getContents());
        }

        throw new NominatimException('Format is undefined or not supported for decode response', $request, $response);
    }
}
