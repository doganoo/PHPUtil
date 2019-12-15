<?php
/**
 * MIT License
 * Copyright (c) 2018 Dogan Ucar, <dogan@dogan-ucar.de>
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace doganoo\PHPUtil\Util;
/**
 * Class NumberUtil
 *
 * @package doganoo\PHPUtil\Util
 */
final class NumberUtil {

    /**
     * prevent from instantiation
     * StringUtil constructor.
     */
    private function __construct() {
    }

    /**
     * returns the formatted number with grouped thousands
     *
     * @param     $value
     * @param int $decimals
     *
     * @return null|string
     */
    public static function format($value, int $decimals = 2): ?string {
        if (!\is_numeric($value)) {
            return null;
        }
        return \number_format($value, $decimals);
    }

    /**
     * returns an array with the elements
     *
     * @param int $number
     *
     * @return array
     */
    public static function intToArray(int $number): array {
        return StringUtil::stringToArray($number);
    }

    /**
     * This method checks if $value is greater than $value1. If $gte is set to
     * true, the method checks if $value is greater than or equal to $value1.
     * From http://php.net/manual/de/language.types.float.php:
     * So never trust floating number results to the last digit, and do not
     * compare floating point numbers directly for equality.
     * Contributed notes in http://php.net/manual/de/language.types.float.php
     * suggests rounding the values before comparing (see 115 catalin dot luntraru at gmail dot com).
     *
     * @param float $value
     * @param float $value1
     * @param bool  $gte
     *
     * @return bool
     * @since 1.0.0
     */
    public static function floatGreaterThan(float $value, float $value1, bool $gte = false) {
        $value  = round($value, 10, PHP_ROUND_HALF_EVEN);
        $value1 = round($value1, 10, PHP_ROUND_HALF_EVEN);
        if ($gte) {
            return $value >= $value1;
        } else {
            return $value > $value1;
        }
    }

    /**
     * This method compares two float numbers for equality. PHP float values
     * should never be compared directly, according to: http://php.net/manual/de/language.types.float.php
     *
     * @param float $value
     * @param float $value1
     *
     * @return bool
     */
    public static function compareFloat(float $value, float $value1) {
        $epsilon = 0.00001;
        if (abs($value - $value1) < $epsilon) {
            return true;
        }
        return false;
    }

    /**
     * strips all non integer fields from the input and returns all
     * values as integer data type.
     *
     * @param array $array
     * @return array
     */
    public static function stripNonInteger(array $array): array {
        $newArray = [];
        foreach ($array as $value) {
            if (!NumberUtil::isInteger($value)) continue;
            $newArray[] = \intval($value);
        }
        return $newArray;
    }

    /**
     * whether $value is an integer or not.
     * Notice that intval() returns a zero if the value is not an integer :/
     *
     * Therefore, we use "filter_var()" method, see here:
     * https://stackoverflow.com/a/29018655/1966490
     *
     * @param $value
     * @return bool
     */
    public static function isInteger($value): bool {
        return false !== filter_var($value, FILTER_VALIDATE_INT);
    }

}