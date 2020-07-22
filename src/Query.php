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
 * Class implementing functionality common to requests nominatim.
 */
abstract class Query implements QueryInterface
{
    /**
     * Contain the path of the request.
     *
     * @var string
     */
    protected $path;

    /**
     * Contain the query for request.
     *
     * @var array
     */
    protected $query = [];

    /**
     * Contain the format for decode data returning by the request.
     *
     * @var string
     */
    protected $format;

    /**
     * Output format accepted.
     *
     * @var array
     */
    protected $acceptedFormat = ['xml', 'json', 'jsonv2', 'geojson', 'geocodejson'];

    /**
     * Output polygon format accepted.
     *
     * @var array
     */
    protected $polygon = ['geojson', 'kml', 'svg', 'text'];

    /**
     * Constuctor.
     *
     * @param array $query Default value for this query
     */
    public function __construct(array &$query = [])
    {
        if (empty($query['format'])) {
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
     * @param string $format The output format for the request
     *
     * @throws \maxh\Nominatim\Exceptions\InvalidParameterException if format is not supported
     *
     * @return \maxh\Nominatim\Details|\maxh\Nominatim\Lookup|\maxh\Nominatim\Reverse|\maxh\Nominatim\Search
     */
    final public function format(string $format): self
    {
        $format = mb_strtolower($format);

        if (\in_array($format, $this->acceptedFormat, true)) {
            $this->setFormat($format);

            return $this;
        }

        throw new InvalidParameterException('Format is not supported');
    }

    /**
     * Preferred language order for showing search results, overrides the value
     * specified in the "Accept-Language" HTTP header. Either uses standard
     * rfc2616 accept-language string or a simple comma separated list of
     * language codes.
     *
     * @param string $language Preferred language order for showing search results, overrides the value
     *                         specified in the "Accept-Language" HTTP header. Either uses standard rfc2616
     *                         accept-language string or a simple comma separated list of language codes.
     *
     * @return \maxh\Nominatim\Details|\maxh\Nominatim\Lookup|\maxh\Nominatim\Reverse|\maxh\Nominatim\Search
     */
    final public function language(string $language): self
    {
        $this->query['accept-language'] = $language;

        return $this;
    }

    /**
     * Include a breakdown of the address into elements.
     *
     * @return \maxh\Nominatim\Details|\maxh\Nominatim\Lookup|\maxh\Nominatim\Reverse|\maxh\Nominatim\Search
     */
    public function addressDetails(bool $details = true): self
    {
        $this->query['addressdetails'] = $details ? '1' : '0';

        return $this;
    }

    /**
     * If you are making large numbers of request please include a valid email address or alternatively include your
     * email address as part of the User-Agent string. This information will be kept confidential and only used to
     * contact you in the event of a problem, see Usage Policy for more details.
     *
     * @param string $email Address mail
     *
     * @return \maxh\Nominatim\Details|\maxh\Nominatim\Lookup|\maxh\Nominatim\Reverse|\maxh\Nominatim\Search
     */
    public function email(string $email): self
    {
        $this->query['email'] = $email;

        return $this;
    }

    /**
     * Output format for the geometry of results.
     *
     * @throws \maxh\Nominatim\Exceptions\InvalidParameterException if polygon format is not supported
     *
     * @return \maxh\Nominatim\Details|\maxh\Nominatim\Query|\maxh\Nominatim\Reverse|\maxh\Nominatim\Search
     */
    public function polygon(string $polygon)
    {
        if (\in_array($polygon, $this->polygon, true)) {
            $this->query['polygon_'.$polygon] = '1';

            return $this;
        }

        throw new InvalidParameterException('This polygon format is not supported');
    }

    /**
     * Include additional information in the result if available.
     *
     * @return \maxh\Nominatim\Details|\maxh\Nominatim\Lookup|\maxh\Nominatim\Reverse|\maxh\Nominatim\Search
     */
    public function extraTags(bool $tags = true): self
    {
        $this->query['extratags'] = $tags ? '1' : '0';

        return $this;
    }

    /**
     * Include a list of alternative names in the results.
     * These may include language variants, references, operator and brand.
     *
     * @return \maxh\Nominatim\Details|\maxh\Nominatim\Lookup|\maxh\Nominatim\Reverse|\maxh\Nominatim\Search
     */
    public function nameDetails(bool $details = true): self
    {
        $this->query['namedetails'] = $details ? '1' : '0';

        return $this;
    }

    /**
     * Returns the URL-encoded query.
     */
    public function getQueryString(): string
    {
        return http_build_query($this->query);
    }

    // -- Getters & Setters ----------------------------------------------------

    /**
     * Get path.
     */
    final public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get query.
     */
    final public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * Get format.
     */
    final public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Set path.
     *
     * @param string $path Name's path of the service
     */
    protected function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * Set query.
     *
     * @param array $query Parameter of the query
     */
    protected function setQuery(array &$query = []): void
    {
        $this->query = $query;
    }

    /**
     * Set format.
     *
     * @param string $format Format returning by the response
     */
    protected function setFormat(string $format): void
    {
        $this->format = $this->query['format'] = $format;
    }
}
