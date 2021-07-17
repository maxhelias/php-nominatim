<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace maxh\Nominatim\Exceptions;

use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * InvalidParameterException exception is thrown when a request failed because of a bad client configuration.
 *
 * InvalidParameterException appears when the request failed because of a bad parameter from
 * the client request.
 *
 * @category Exceptions
 */
class NominatimException extends Exception
{
    /**
     * Contain the request.
     *
     * @var RequestInterface
     */
    private $request;

    /**
     * Contain the response.
     *
     * @var ResponseInterface
     */
    private $response;

    /**
     * Constructor.
     *
     * @param string                 $message  Message of this exception
     * @param null|RequestInterface  $request  The request instance
     * @param null|ResponseInterface $response The response of the request
     * @param null|Exception         $previous Exception object
     */
    public function __construct(
        $message,
        ?RequestInterface $request = null,
        ?ResponseInterface $response = null,
        ?Exception $previous = null
    ) {
        // Set the code of the exception if the response is set and not future.
        $code = $response && !($response instanceof PromiseInterface) ? $response->getStatusCode() : 0;

        parent::__construct($message, $code, $previous);

        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Return the Request.
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * Return the Response.
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
