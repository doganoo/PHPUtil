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

namespace doganoo\PHPUtil\Datatype;

/**
 * Class PString - bases on Java String class
 *
 * @package doganoo\PHPUtil\System
 */
class StringClass {
    /**
     * @var string
     */
    private $value = "";

    /**
     * PString constructor.
     *
     * @param $value
     */
    public function __construct($value) {
        $this->setValue($value);
    }

    /**
     * checks whether the given string/PString equals to the value
     *
     * @param $value
     * @return bool
     */
    public function equals($value) {
        if ($value instanceof StringClass) {
            $value = $value->getValue();
        }
        if (!is_string($value)) return false;
        return strcmp($this->value, $value) === 0;
    }

    /**
     * returns the string
     *
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * sets the value
     *
     * @param $value
     */
    public function setValue($value) {
        $this->value = (string) $value;
    }

    /**
     * checks whether the given string/PString equals to the value and is case insensitive
     *
     * @param $value
     * @return bool
     */
    public function equalsIgnoreCase($value) {
        if ($value instanceof StringClass) {
            $value = $value->getValue();
        }
        if (!is_string($value)) return false;
            return strcasecmp($this->value, $value) === 0;
    }

    /**
     * string representation of this class
     *
     * @return string
     */
    public function __toString() {
        return $this->value;
    }

    /**
     * checks whether $value is in the string
     *
     * @param $value
     * @return bool
     */
    public function contains($value) {
        return strpos($this->value, $value) !== false;
    }

    /**
     * checks whether $value is in the string and is case insensitive
     *
     * @param $value
     * @return bool
     */
    public function containsIgnoreCase($value) {
        return stripos($this->value, $value) !== false;
    }

    /**
     * replaces search by value
     *
     * @param $search
     * @param $value
     */
    public function replace($search, $value) {
        $this->value = str_replace($search, $value, $this->value);
    }

    /**
     * replaces search by value and is case insensitive
     *
     * @param $search
     * @param $value
     */
    public function replaceIgnoreCase($search, $value) {
        $this->value = str_ireplace($search, $value, $this->value);
    }

    /**
     * performs a regular expression pattern matching
     *
     * @param       $pattern
     * @param array $matches
     * @return bool
     */
    public function match($pattern, &$matches = []) {
        return preg_match($pattern, $this->value, $matches) === 1;
    }

    /**
     * performs a regular expression pattern matching replacement
     *
     * @param $pattern
     * @param $replace
     * @return string
     */
    public function pregReplace($pattern, $replace): string {
        return preg_replace($pattern, $replace, $this->value);
    }

    /**
     * returns the string with lower case letters
     *
     * @return string
     */
    public function toLowerCase() {
        return strtolower($this->value);
    }

    /**
     * returns a substring
     *
     * @param int $count
     * @return bool|string
     */
    public function getSubstring(int $count) {
        $return = substr($this->value, 0, $count);
        return $return;
    }

    /**
     * checks a prefix
     *
     * have a look here: https://stackoverflow.com/a/2790919
     *
     * @param string $prefix
     * @return bool
     */
    public function hasPrefix(string $prefix):bool {
        return true === (substr( $this->getValue(), 0, strlen($prefix)) === $prefix);
    }
}