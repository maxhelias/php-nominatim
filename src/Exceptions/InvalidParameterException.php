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

/**
 * InvalidParameterException exception is thrown when a request failed because of a bad client configuration.
 *
 * InvalidParameterException appears when the request failed because of a bad parameter from
 * the client request.
 *
 * @category Exceptions
 */
class InvalidParameterException extends Exception
{
}
