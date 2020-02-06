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

namespace Ramsey\Base\Test;

use Ramsey\Base\Converter;

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
use const Ramsey\Base\BASE_62_X;
use const Ramsey\Base\BASE_64;
use const Ramsey\Base\BASE_64_URL;
use const Ramsey\Base\BASE_8;
use const Ramsey\Base\BASE_85_RFC;
use const Ramsey\Base\BASE_85_ZMQ;
use const Ramsey\Base\BASE_91;

class ConverterTest extends TestCase
{
    /**
     * @param string|int $number
     * @param string|int $fromBase
     * @param string|int $toBase
     * @dataProvider provideInvalidValues
     */
    public function testExceptionForInvalidCharactersInBase($number, $fromBase, $toBase): void
    {
        $converter = new Converter();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(sprintf(
                'Invalid characters found in base%s value `%s\'',
                $fromBase,
                $number
        ));

        $converter->convert($number, $fromBase, $toBase);
    }

    /**
     * @param string $expected
     * @param string|int $number
     * @param string|int $fromBase
     * @param string|int $toBase
     * @dataProvider provideConversionTests
     */
    public function testConvert(string $expected, $number, $fromBase, $toBase): void
    {
        $converter = new Converter();

        $this->assertSame($expected, $converter->convert($number, $fromBase, $toBase));
    }

    public function provideConversionTests(): array
    {
        return array_merge($this->generateSymbolsTests(), [
            [
                'expected' => '1715be4cdb2392e8df8ae23d6969d0de8d8ca06d7ae888e6d95',
                'number' => 'nX,<:WRT%yV%!5:maref3+1RrUb64^M',
                'fromBase' => BASE_91,
                'toBase' => BASE_16,
            ],
            [
                'expected' => '864fd26f',
                'number' => 'Hello',
                'fromBase' => BASE_85_ZMQ,
                'toBase' => BASE_16,
            ],
            [
                'expected' => 'b559f75b',
                'number' => 'World',
                'fromBase' => BASE_85_ZMQ,
                'toBase' => BASE_16,
            ],
            [
                'expected' => 'Hello',
                'number' => '864fd26f',
                'fromBase' => BASE_16,
                'toBase' => BASE_85_ZMQ,
            ],
            [
                'expected' => 'World',
                'number' => 'b559f75b',
                'fromBase' => BASE_16,
                'toBase' => BASE_85_ZMQ,
            ],
            [
                'expected' => '21932261930451111902915077091070067066',
                'number' => '108000000000000000080800200C417A',
                'fromBase' => BASE_16,
                'toBase' => BASE_10,
            ],
            [
                'expected' => '108000000000000000080800200c417a',
                'number' => '21932261930451111902915077091070067066',
                'fromBase' => BASE_10,
                'toBase' => BASE_16,
            ],
            [
                'expected' => '4)+k&C#VzJ4br>0wv%Yp',
                'number' => '108000000000000000080800200c417a',
                'fromBase' => BASE_16,
                'toBase' => BASE_85_RFC,
            ],
            [
                'expected' => '108000000000000000080800200c417a',
                'number' => '4)+k&C#VzJ4br>0wv%Yp',
                'fromBase' => BASE_85_RFC,
                'toBase' => BASE_16,
            ],
            [
                'expected' => '14672002',
                'number' => 14672002,
                'fromBase' => BASE_10,
                'toBase' => BASE_10,
            ],
            [
                'expected' => '14672002',
                'number' => 'ezs42',
                'fromBase' => BASE_32_GEOHASH,
                'toBase' => BASE_10,
            ],
            [
                'expected' => '804D',
                'number' => '20010d',
                'fromBase' => BASE_16,
                'toBase' => BASE_62_X,
            ],
            [
                'expected' => '20010d',
                'number' => '804D',
                'fromBase' => BASE_62_X,
                'toBase' => BASE_16,
            ],
            [
                'expected' => 'k000',
                'number' => 'b80000',
                'fromBase' => BASE_16,
                'toBase' => BASE_62_X,
            ],
            [
                'expected' => 'b80000',
                'number' => 'k000',
                'fromBase' => BASE_62_X,
                'toBase' => BASE_16,
            ],
            [
                'expected' => '2zy',
                'number' => '2f3b',
                'fromBase' => BASE_16,
                'toBase' => BASE_62_X,
            ],
            [
                'expected' => '2f3b',
                'number' => '2zy',
                'fromBase' => BASE_62_X,
                'toBase' => BASE_16,
            ],
            [
                'expected' => 'ge0',
                'number' => '2aa00',
                'fromBase' => BASE_16,
                'toBase' => BASE_62_X,
            ],
            [
                'expected' => '2aa00',
                'number' => 'ge0',
                'fromBase' => BASE_62_X,
                'toBase' => BASE_16,
            ],
            [
                'expected' => 'x3x3ue',
                'number' => 'fffe28',
                'fromBase' => BASE_16,
                'toBase' => BASE_62_X,
            ],
            [
                'expected' => 'fffe28',
                'number' => 'x3x3ue',
                'fromBase' => BASE_62_X,
                'toBase' => BASE_16,
            ],
            [
                'expected' => '9nQ',
                'number' => '9c5a',
                'fromBase' => BASE_16,
                'toBase' => BASE_62_X,
            ],
            [
                'expected' => '9c5a',
                'number' => '9nQ',
                'fromBase' => BASE_62_X,
                'toBase' => BASE_16,
            ],
            [
                'expected' => '27',
                'number' => '111111111111111111111111111',
                'fromBase' => BASE_1,
                'toBase' => BASE_10,
            ],
            [
                'expected' => '111111111111111111111111111',
                'number' => 27,
                'fromBase' => BASE_10,
                'toBase' => BASE_1,
            ],
            [
                'expected' => '101',
                'number' => '11111',
                'fromBase' => BASE_1,
                'toBase' => BASE_2,
            ],
            [
                'expected' => '8',
                'number' => '10',
                'fromBase' => BASE_8,
                'toBase' => BASE_10,
            ],
            [
                'expected' => '512',
                'number' => '1000',
                'fromBase' => BASE_8,
                'toBase' => BASE_10,
            ],
            [
                'expected' => '1000',
                'number' => 512,
                'fromBase' => BASE_10,
                'toBase' => BASE_8,
            ],
            [
                'expected' => '7fffffffffffffff',
                'number' => '9223372036854775807',
                'fromBase' => BASE_10,
                'toBase' => BASE_16,
            ],
            [
                'expected' => '340282366920938463463374607431768211455',
                'number' => 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
                'fromBase' => BASE_16,
                'toBase' => BASE_10,
            ],
            [
                'expected' => '11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111',
                'number' => 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
                'fromBase' => BASE_16,
                'toBase' => BASE_2,
            ],
            [
                'expected' => 'ffffffffffffffffffffffffffffffff',
                'number' => '11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111',
                'fromBase' => BASE_2,
                'toBase' => BASE_16,
            ],
            [
                'expected' => '3777777777777777777777777777777777777777777',
                'number' => 'ffffffffffffffffffffffffffffffff',
                'fromBase' => BASE_16,
                'toBase' => BASE_8,
            ],
            [
                'expected' => '7zzzzzzzzzzzzzzzzzzzzzzzzz',
                'number' => 'ffffffffffffffffffffffffffffffff',
                'fromBase' => BASE_16,
                'toBase' => BASE_32_CROCKFORD,
            ],
            [
                'expected' => '340282366920938463463374607431768211455',
                'number' => '7zzzzzzzzzzzzzzzzzzzzzzzzz',
                'fromBase' => BASE_32_CROCKFORD,
                'toBase' => BASE_10,
            ],
            [
                'expected' => '89999999999999999999999999',
                'number' => 'ffffffffffffffffffffffffffffffff',
                'fromBase' => BASE_16,
                'toBase' => BASE_32_Z,
            ],
            [
                'expected' => '7vvvvvvvvvvvvvvvvvvvvvvvvv',
                'number' => 'ffffffffffffffffffffffffffffffff',
                'fromBase' => BASE_16,
                'toBase' => BASE_32_HEX,
            ],
            [
                'expected' => 'h7777777777777777777777777',
                'number' => 'ffffffffffffffffffffffffffffffff',
                'fromBase' => BASE_16,
                'toBase' => BASE_32,
            ],
            [
                'expected' => 'usz5xbbiqsfq7s727m0pzr2xa',
                'number' => 'ffffffffffffffffffffffffffffffff',
                'fromBase' => BASE_16,
                'toBase' => BASE_35,
            ],
            [
                'expected' => 'D/////////////////////',
                'number' => 'ffffffffffffffffffffffffffffffff',
                'fromBase' => BASE_16,
                'toBase' => BASE_64,
            ],
            [
                'expected' => 'D_____________________',
                'number' => 'ffffffffffffffffffffffffffffffff',
                'fromBase' => BASE_16,
                'toBase' => BASE_64_URL,
            ],
        ]);
    }

    public function generateSymbolsTests(): array
    {
        $tests = [];

        foreach (Symbol::TABLE as $fromBase => $symbols) {
            if ($fromBase === BASE_1) {
                $tests[] = [
                    'expected' => (string) strlen($symbols),
                    'number' => $symbols,
                    'fromBase' => $fromBase,
                    'toBase' => BASE_10,
                ];

                continue;
            }

            $symbols = str_split($symbols);

            foreach ($symbols as $index => $symbol) {
                $symbol = str_replace(
                    Symbol::RULES[$fromBase][Symbol::SUBSTITUTE] ?? '',
                    Symbol::RULES[$fromBase][Symbol::ACTUAL] ?? '',
                    $symbol
                );

                $tests[] = [
                    'expected' => (string) $index,
                    'number' => $symbol,
                    'fromBase' => $fromBase,
                    'toBase' => BASE_10,
                ];
            }
        }

        return $tests;
    }

    public function provideInvalidValues(): array
    {
        $tests = [];

        foreach (Symbol::TABLE as $fromBase => $symbols) {
            $tests[] = [
                'number' => $symbols . '\\' . $symbols,
                'fromBase' => $fromBase,
                'toBase' => BASE_10,
            ];
        }

        return $tests;
    }
}
