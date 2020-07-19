<?php

declare(strict_types=1);

/**
 * This file is part of PHP Nominatim.
 * (c) Maxime Hélias <maximehelias16@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace maxh\Nominatim\Consts;

/**
 * Constants for osm types.
 *
 * Class OsmTypes
 */
class OsmTypes
{
    public const NODE = 'N';
    public const WAY = 'W';
    public const RELATIVE = 'R';

    /**
     * All Osm Types.
     */
    public static function all(): array
    {
        return [self::NODE, self::WAY, self::RELATIVE];
    }
}
