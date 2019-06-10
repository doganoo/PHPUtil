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

namespace doganoo\PHPUtil\DI;

use doganoo\PHPAlgorithms\Datastructure\Lists\Node;
use doganoo\PHPAlgorithms\Datastructure\Maps\HashMap;
use doganoo\PHPUtil\Exception\ClassNotFoundException;
use Exception;
use ReflectionClass;
use ReflectionParameter;

/**
 * Alternative approach to doganoo\PHPUtil\Util\AppContainer
 *
 * The main differences are:
 *      * no static class
 *      * using reflection - no adding needed
 *      * under construction ! use on your own risk!
 *
 * Future features:
 *      * add own classes
 *      * support stateful / stateless classes
 *
 * Class Container
 * @package doganoo\PHPUtil\DI
 */
class Container {

    private $instances = null;

    private $created = null;

    public function __construct() {
        $this->instances = new HashMap();
        $this->created = new HashMap();
    }

    public function add(string $name, callable $callable):void {
        $this->instances->add($name, $callable);
    }
    /**
     * retrieving the container instance.
     *
     * @param string $name
     * @param array $params
     *
     * @return mixed|null
     */
    public function get(string $name, ...$params) {
        if ($this->created->containsKey($name)) return $this->created->getNodeByKey($name)->getValue();
        if ($this->instances->containsKey($name)) return $this->fromInstances($name, $params);

        try {
            $reflectionClass = new ReflectionClass($name);
            if (false === $reflectionClass->isInstantiable()) return null;
            $constructor = $reflectionClass->getConstructor();
            $parameters = [];

            if (null !== $constructor) {
                /** @var ReflectionParameter $parameter */
                foreach ($constructor->getParameters() as $parameter) {
                    $className = $parameter->getClass()->getName();
                    $class = $this->get($className);
                    if (null === $class) throw new ClassNotFoundException();
                    $parameters[] = $class;
                }
            }
            $clazz = $reflectionClass->newInstanceArgs($parameters + $params);
            $this->created->add($name, $clazz);
            return $clazz;
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * @param string $name
     * @param mixed ...$params
     * @return mixed|null
     */
    private function fromInstances(string $name, ...$params){
        if (false === $this->instances->containsKey($name)) return null;

        /** @var Node $node */
        $node = $this->instances->getNodeByKey($name);
        if (null === $node) {
            return null;
        }
        $clazz = $node->getValue()($params);
        $this->created->add($name, $clazz);
        return $clazz;
    }

}