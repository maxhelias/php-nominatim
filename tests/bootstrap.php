<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
\error_reporting(E_ALL);

include_once \dirname(__DIR__) . '/vendor/autoload.php';

\PHPUnit\Framework\Error\Notice::$enabled = true;
