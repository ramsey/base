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

use Brick\Math\BigInteger;
use RuntimeException;

final class Converter
{
    /**
     * @param string|int $number
     * @param string|int $fromBase
     * @param string|int $toBase
     *
     * @return string
     */
    public function convert($number, $fromBase, $toBase): string
    {
        if ((int) $fromBase < 36) {
            $number = strtolower((string) $number);
        }

        $this->assertCharactersInBase($number, $fromBase);

        if ($fromBase !== BASE_10) {
            $number = $this->baseXtoBase10($number, $fromBase);
        }

        if ($toBase === BASE_10) {
            return (string) $number;
        }

        return $this->base10toBaseX($number, $toBase);
    }

    private function baseXtoBase10($number, $fromBase)
    {
        if ($fromBase === BASE_1) {
            return strlen($number);
        }

        $base = BigInteger::of(Symbol::RULES[$fromBase][Symbol::LENGTH] ?? (int) $fromBase);

        $number = str_replace(
            Symbol::RULES[$fromBase][Symbol::ACTUAL] ?? '',
            Symbol::RULES[$fromBase][Symbol::SUBSTITUTE] ?? '',
            $number
        );

        $number = array_reverse(str_split($number));
        $baseAlphabet = str_split(Symbol::TABLE[$fromBase]);

        $return = BigInteger::zero();
        foreach ($number as $position => $symbol) {
            $value = BigInteger::of(array_search($symbol, $baseAlphabet));
            $return = $return->plus($value->multipliedBy($base->power($position)));
        }

        return (string) $return;
    }

    private function base10toBaseX($number, $toBase)
    {
        $base = Symbol::RULES[$toBase][Symbol::LENGTH] ?? (int) $toBase;
        $value = BigInteger::of($number);
        $return = '';

        do {
            $return = Symbol::TABLE[$toBase][$value->mod($base)->toInt()] . $return;

            if ($base === 1) {
                $value = $value->minus(1);
                continue;
            }

            $value = $value->quotient($base);
        } while ($value->isGreaterThan(0));

        $return = str_replace(
            Symbol::RULES[$toBase][Symbol::SUBSTITUTE] ?? '',
            Symbol::RULES[$toBase][Symbol::ACTUAL] ?? '',
            $return
        );

        return $return;
    }

    private function assertCharactersInBase(string $number, $fromBase): bool
    {
        $symbols = Symbol::TABLE[$fromBase];

        // Get rid of any substitute symbols.
        $symbols = str_replace(
            Symbol::RULES[$fromBase][Symbol::SUBSTITUTE] ?? '',
            '',
            $symbols
        );

        // Escape special characters.
        $symbols = str_replace(
            ['/', ']', '$', '-'],
            ['\/', '\]', '\$', '\-'],
            $symbols
        );

        $expression = '/^([' . $symbols . ']';

        // Add any actual symbols to the expression.
        foreach ((Symbol::RULES[$fromBase][Symbol::ACTUAL] ?? []) as $symbol) {
            $expression .= '|' . $symbol;
        }

        $expression .= ')*$/';

        if (!preg_match($expression, $number)) {
            throw new RuntimeException(sprintf(
                'Invalid characters found in base%s value `%s\'',
                $fromBase,
                $number
            ));
        }

        return true;
    }
}
