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

use doganoo\PHPAlgorithms\Datastructure\Lists\Node;
use doganoo\PHPAlgorithms\Datastructure\Maps\HashMap;

/**
 * Class AppContainer - container class for instances.
 *
 * @package doganoo\PHPUtil\Util
 */
class AppContainer {

    /** @var HashMap $map */
    private static $map = null;

    /**
     * AppContainer constructor - private constructor in order
     * to prevent instantiation.
     *
     */
    private function __construct() {
    }

    /**
     * @param string   $name
     * @param callable $callable
     * @throws \doganoo\PHPAlgorithms\common\Exception\InvalidKeyTypeException
     * @throws \doganoo\PHPAlgorithms\common\Exception\UnsupportedKeyTypeException
     * @throws \ReflectionException
     */
    public static function add(string $name, callable $callable) {
        $map = self::getInstance();
        $map->add($name, $callable);
    }

    /**
     * returning the Map instance.
     *
     * @return HashMap
     */
    private static function getInstance(): HashMap {
        if (null === self::$map) {
            self::$map = new HashMap();
        }
        return self::$map;
    }

    /**
     * retrieving the container instance.
     *
     * @param string $name
     * @param array $params
     *
     * @return int|null
     * @throws \doganoo\PHPAlgorithms\common\Exception\InvalidKeyTypeException
     * @throws \doganoo\PHPAlgorithms\common\Exception\UnsupportedKeyTypeException
     */
    public static function get(string $name, ...$params) {
        $map = self::getInstance();
        if (!$map->containsKey($name)) {
            return null;
        }
        /** @var Node $node */
        $node = $map->getNodeByKey($name);
        if (null === $node) {
            return null;
        }
        return $node->getValue()($params);
    }

    /**
     * returns all class names as an array
     *
     * @return array
     */
    public static function getClasses(): array {
        $classNames = self::$map->keySet();
        return $classNames;
    }
}