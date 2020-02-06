<?php

/**
 * This file is part of the ramsey/base library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey <ben@benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

declare(strict_types=1);

namespace Ramsey\Base;

final class Symbol
{
    public const TABLE = [
        BASE_1 => '1',
        BASE_2 => '01',
        BASE_8 => '01234567',
        BASE_10 => '0123456789',
        BASE_16 => '0123456789abcdef',
        BASE_32 => 'abcdefghijklmnopqrstuvwxyz234567',
        BASE_32_CROCKFORD => '0123456789abcdefghjkmnpqrstvwxyz',
        BASE_32_GEOHASH => '0123456789bcdefghjkmnpqrstuvwxyz',
        BASE_32_HEX => '0123456789abcdefghijklmnopqrstuv',
        BASE_32_Z => 'ybndrfg8ejkmcpqxot1uwisza345h769',
        BASE_35 => '0123456789abcdefghijklmnpqrstuvwxyz',
        BASE_36 => '0123456789abcdefghijklmnopqrstuvwxyz',
        BASE_62_X => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwyz$&*',
        BASE_64 => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/',
        BASE_64_URL => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_',
        BASE_85_RFC => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!#$%&()*+-;<=>?@^_`{|}~',
        BASE_85_ZMQ => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.-:+=^!/*?&<>()[]{}@%$#',
        BASE_91 => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!#$%&()*+,./:;<=>?@[]^_`{|}~"',
    ];

    public const SUBSTITUTE = 0;
    public const ACTUAL = 1;
    public const LENGTH = 2;

    public const RULES = [
        BASE_62_X => [
            self::SUBSTITUTE => ['$', '&', '*'],
            self::ACTUAL => ['x1', 'x2', 'x3'],
            self::LENGTH => 64,
        ],
    ];

    /**
     * Disallow instantiation of this class.
     *
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }
}
