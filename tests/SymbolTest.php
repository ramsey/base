<?php

declare(strict_types=1);

namespace Ramsey\Base\Test;

use Error;
use Ramsey\Base\Symbol;

use const Ramsey\Base\BASE_1;
use const Ramsey\Base\BASE_10;
use const Ramsey\Base\BASE_16;
use const Ramsey\Base\BASE_2;
use const Ramsey\Base\BASE_32;
use const Ramsey\Base\BASE_32_CROCKFORD;
use const Ramsey\Base\BASE_32_GEOHASH;
use const Ramsey\Base\BASE_32_HEX;
use const Ramsey\Base\BASE_32_Z;
use const Ramsey\Base\BASE_35;
use const Ramsey\Base\BASE_36;
use const Ramsey\Base\BASE_62_X;
use const Ramsey\Base\BASE_64;
use const Ramsey\Base\BASE_64_URL;
use const Ramsey\Base\BASE_8;
use const Ramsey\Base\BASE_85_RFC;
use const Ramsey\Base\BASE_85_ZMQ;
use const Ramsey\Base\BASE_91;

class SymbolTest extends TestCase
{
    public function testTableConstant(): void
    {
        $this->assertSame(
            [
                1 => '1',
                2 => '01',
                8 => '01234567',
                10 => '0123456789',
                16 => '0123456789abcdef',
                32 => 'abcdefghijklmnopqrstuvwxyz234567',
                '32-crockford' => '0123456789abcdefghjkmnpqrstvwxyz',
                '32-geohash' => '0123456789bcdefghjkmnpqrstuvwxyz',
                '32-hex' => '0123456789abcdefghijklmnopqrstuv',
                '32-z' => 'ybndrfg8ejkmcpqxot1uwisza345h769',
                35 => '0123456789abcdefghijklmnpqrstuvwxyz',
                36 => '0123456789abcdefghijklmnopqrstuvwxyz',
                '62-x' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwyz$&*',
                64 => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/',
                '64-url' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_',
                '85-rfc' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!#$%&()*+-;<=>?@^_`{|}~',
                '85-zmq' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.-:+=^!/*?&<>()[]{}@%$#',
                91 => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!#$%&()*+,./:;<=>?@[]^_`{|}~"',
            ],
            Symbol::TABLE
        );
    }

    public function testRulesConstant(): void
    {
        $this->assertSame(
            [
                BASE_62_X => [
                    0 => ['$', '&', '*'],
                    1 => ['x1', 'x2', 'x3'],
                    2 => 64,
                ],
            ],
            Symbol::RULES
        );
    }

    public function testRulesKeysConstants(): void
    {
        $this->assertSame(0, Symbol::SUBSTITUTE);
        $this->assertSame(1, Symbol::ACTUAL);
        $this->assertSame(2, Symbol::LENGTH);
    }

    public function testInstantiationDenied(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage(
            'Call to private Ramsey\Base\Symbol::__construct() from context '
            . '\'Ramsey\Base\Test\SymbolTest\''
        );

        new Symbol();
    }
}
