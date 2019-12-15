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

use doganoo\PHPAlgorithms\common\Exception\InvalidKeyTypeException;
use doganoo\PHPAlgorithms\common\Exception\UnsupportedKeyTypeException;
use doganoo\PHPAlgorithms\Datastructure\Lists\Node;
use doganoo\PHPAlgorithms\Datastructure\Maps\HashMap;
use doganoo\PHPUtil\Exception\ClassNotFoundException;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

/**
 * Class AppContainer - container class for instances.
 *
 * @package doganoo\PHPUtil\Util
 */
class AppContainer {

    /** @var HashMap $map */
    private static $map = null;
    /** @var HashMap $cache */
    private static $cache = null;
    /** @var bool $autoLoad */
    private static $autoLoad = false;

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
     * @throws InvalidKeyTypeException
     * @throws UnsupportedKeyTypeException
     * @throws ReflectionException
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
            self::$map   = new HashMap();
            self::$cache = new HashMap();
        }
        return self::$map;
    }

    /**
     * retrieving the container instance.
     *
     * @param string $name
     * @param array  $params
     *
     * @return mixed|null
     * @throws InvalidKeyTypeException
     * @throws UnsupportedKeyTypeException
     */
    public static function get(string $name, ...$params) {
        // we check the cache: if there is an instance already created
        // we use the created instance instead
        // TODO: use force create: if user wants to force an new instance
        //      we need to skip the cache
        if (AppContainer::isCached($name)) {
            return self::$cache->getNodeByKey($name)->getValue();
        }

        // experimental feature: set autoload to true if you want to use autowiring
        if (AppContainer::isAutoLoad()) return self::getAutoLoad($name, $params);

        $map = self::getInstance();
        if (!$map->containsKey($name)) {
            return null;
        }
        /** @var Node $node */
        $node = $map->getNodeByKey($name);
        if (null === $node) {
            return null;
        }
        // we create the instance and add it to the cache
        $instance = $node->getValue()($params);
        self::$cache->add($name, $instance);

        return $instance;
    }

    /**
     * @param string $name
     * @param mixed  ...$params
     * @return object|null
     */
    private static function getAutoLoad(string $name, ...$params) {
        try {
            $reflectionClass = new ReflectionClass($name);
            $constructor     = $reflectionClass->getConstructor();
            $parameters      = [];

            if (null !== $constructor) {
                /** @var ReflectionParameter $parameter */
                foreach ($constructor->getParameters() as $parameter) {
                    $className = $parameter->getClass()->getName();
                    $class     = AppContainer::get($className);
                    if (null === $class) throw new ClassNotFoundException();
                    $parameters[] = $class;
                }
            }
            $clazz = $reflectionClass->newInstanceArgs($parameters + $params);
            return $clazz;
        } catch (ClassNotFoundException $exception) {
            return null;
        }
    }

    private static function isCached(string $name): bool {
        return true === self::$cache->containsKey($name);
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

    /**
     * WARNING: THIS MODE IS EXPERIMENTAL !! USE IT ON YOUR OWN RISK !!
     *
     * @param bool $autoLoad
     */
    public static function setAutoLoad(bool $autoLoad): void {
        self::$autoLoad = $autoLoad;
    }

    /**
     * WARNING: THIS MODE IS EXPERIMENTAL !! USE IT ON YOUR OWN RISK !!
     *
     * @return bool
     */
    public static function isAutoLoad(): bool {
        return self::$autoLoad;
    }

}