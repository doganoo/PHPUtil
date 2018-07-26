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

namespace doganoo\PHPUtil\Util;

/**
 * Class ClassUtil
 *
 * @package doganoo\PHPUtil\Util
 */
final class ClassUtil {

    /**
     * prevent from instantiation
     * StringUtil constructor.
     */
    private function __construct() {
    }

    /**
     * returns the name of an object
     *
     * @param $object
     * @return null|string
     * @throws \ReflectionException
     */
    public static function getClassName($object): ?string {
        $validObject = ClassUtil::isValidObject($object);
        if (!$validObject) {
            return null;
        }
        return (new \ReflectionClass($object))->getName();
    }

    /**
     * validates an object. $object has to be:
     *
     *      1. not null
     *      2. an object verified by \is_object()
     *
     * @param $object
     * @return bool
     */
    private static function isValidObject($object): bool {
        if (null === $object) {
            return false;
        }
        if (!\is_object($object)) {
            return false;
        }
        return true;
    }

    /**
     * returns the unserialized object if the string is serialized.
     * Otherwise, it returns null.
     *
     * @param string $string
     * @return mixed|null
     */
    public static function unserialize(string $string) {
        if (ClassUtil::isSerialized($string)) {
            return \unserialize($string);
        } else {
            return null;
        }
    }

    /**
     * whether the string is an serialized object or not
     *
     * @param string $string
     * @return bool
     */
    public static function isSerialized(string $string): bool {
        $data = @unserialize($string);
        if (false === $data) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * returns all properties of an object
     *
     * TODO let caller define the visibility
     *
     * @param      $object
     * @param bool $asString
     * @return null|\ReflectionProperty[]|string
     * @throws \ReflectionException
     */
    public static function getAllProperties($object, bool $asString = true) {
        $validObject = ClassUtil::isValidObject($object);
        if (!$validObject) {
            return null;
        }
        $reflectionClass = new \ReflectionClass($object);
        $properties = $reflectionClass->getProperties();

        if ($asString) {
            return ArrayUtil::arrayToString($properties);
        } else {
            return $properties;
        }
    }

}