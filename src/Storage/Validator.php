<?php
/**
 * MIT License
 *
 * Copyright (c) 2018 Dogan Ucar, <dogan@dogan-ucar.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace doganoo\PHPUtil\Storage;

/**
 * Class Validator
 *
 * @package doganoo\PHPUtil\Storage
 */
class Validator {
    public const INTEGER = 0;
    public const VARCHAR = 1;
    public const DOUBLE = 3;

    /**
     * Validator constructor.
     */
    private function __construct() {
    }

    /**
     * @param array $array
     * @param int   $dataType
     * @param int   $length
     * @param bool  $mayNull
     * @param bool  $mayEmpty
     * @return bool
     */
    public static function basicArray(
        array $array
        , int $dataType = self::VARCHAR
        , int $length = 0
        , bool $mayNull = false
        , bool $mayEmpty = false): bool {
        $valid = false;
        foreach ($array as $key => $value) {
            $valid |= Validator::basic($value, $dataType, $length, $mayEmpty, $mayNull);
        }
        return $valid;
    }

    /**
     * @param      $value
     * @param int  $dataType
     * @param int  $length
     * @param bool $mayNull
     * @param bool $mayEmpty
     * @return bool
     */
    public static function basic(
        $value
        , int $dataType = self::VARCHAR
        , int $length = 0
        , bool $mayNull = false
        , bool $mayEmpty = false): bool {
        $valid = false;
        if ($dataType === self::INTEGER) {
            $valid |= \is_int($value);
        }
        if ($dataType === self::DOUBLE) {
            $valid |= \is_double($value) || \is_float($value);
        }
        if ($dataType === self::VARCHAR) {
            $valid |= \strlen($value) <= $length;
            if (!$mayEmpty) {
                $valid |= trim($value) !== "";
            }
        }
        if (!$mayNull) {
            $valid |= !\is_null($value);
        }
        return $valid;
    }
}