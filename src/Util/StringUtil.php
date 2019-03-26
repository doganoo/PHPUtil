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
use doganoo\PHPUtil\Datatype\StringClass;

/**
 * Class StringUtil
 *
 * @package doganoo\PHPUtil\Util
 */
final class StringUtil {
    /**
     * prevent from instantiation
     * StringUtil constructor.
     */
    private function __construct() {
    }

    /**
     * returns an array of elements of the string
     *
     * @param null|string $string
     *
     * @return array
     */
    public static function stringToArray(?string $string): array {
        $result = [];
        $strLen = \strlen($string);
        if (null === $string) return $result;
        if (1 === $strLen) {
            $result[] = $string;
            return $result;
        }
        for ($i = 0; $i < $strLen; $i++) {
            $result[] = $string[$i];
        }
        return $result;
    }

    /**
     * returns an UUID.
     * See here: http://www.seanbehan.com/how-to-generate-a-uuid-in-php/
     *
     * @return string
     * @throws \Exception
     */
    public static function getUUID(): string {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function toUTF8(string $string): string {
        $string = iconv('ASCII', 'UTF-8//IGNORE', $string);
        return $string;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function getEncoding(string $string): string {
        return \mb_detect_encoding($string, "auto", true);
    }

    /**
     * @param string $string
     * @param string $prefix
     * @return bool
     */
    public static function hasPrefix(string $string, string $prefix):bool {
        $stringClass = new StringClass($string);
        return $stringClass->hasPrefix($prefix);
    }
}