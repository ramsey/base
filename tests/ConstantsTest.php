<?php

declare(strict_types=1);

namespace Ramsey\Base\Test;

class ConstantsTest extends TestCase
{
    /**
     * @param string $constantName
     * @param string|int $expectedValue
     * @dataProvider provideConstantsTestValues
     */
    public function testConstants(string $constantName, $expectedValue): void
    {
        $this->assertSame($expectedValue, constant($constantName));
    }

    public function provideConstantsTestValues(): array
    {
        return [
            ['Ramsey\Base\BASE_1', 1],
            ['Ramsey\Base\BASE_2', 2],
            ['Ramsey\Base\BASE_8', 8],
            ['Ramsey\Base\BASE_10', 10],
            ['Ramsey\Base\BASE_16', 16],
            ['Ramsey\Base\BASE_32', 32],
            ['Ramsey\Base\BASE_32_CROCKFORD', '32-crockford'],
            ['Ramsey\Base\BASE_32_GEOHASH', '32-geohash'],
            ['Ramsey\Base\BASE_32_HEX', '32-hex'],
            ['Ramsey\Base\BASE_32_Z', '32-z'],
            ['Ramsey\Base\BASE_35', 35],
            ['Ramsey\Base\BASE_36', 36],
            ['Ramsey\Base\BASE_62_X', '62-x'],
            ['Ramsey\Base\BASE_64', 64],
            ['Ramsey\Base\BASE_64_URL', '64-url'],
            ['Ramsey\Base\BASE_85_RFC', '85-rfc'],
            ['Ramsey\Base\BASE_85_ZMQ', '85-zmq'],
            ['Ramsey\Base\BASE_91', 91],
        ];
    }
}
