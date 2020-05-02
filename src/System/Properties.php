<?php
declare(strict_types=1);
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

namespace doganoo\PHPUtil\System;

use doganoo\PHPUtil\Exception\FileNotFoundException;
use doganoo\PHPUtil\Exception\InvalidPropertyStructureException;
use doganoo\PHPUtil\Exception\NoPathException;
use function array_keys;
use function count;
use function is_file;
use function trim;

/**
 * Class Properties
 * @package doganoo\PHPUtil\System
 * @author  Dogan Ucar <dogan@dogan-ucar.de>
 */
class Properties {

    /** @var string */
    private $path;

    /** @var array */
    private $properties;

    /**
     * Properties constructor.
     * @param string $path
     */
    public function __construct(string $path) {
        $this->path = $path;
    }

    /**
     * reads the property value assigned to $key
     * @param string $key
     * @return string|null
     */
    public function read(string $key): ?string {
        $key        = trim($key);
        $properties = $this->loadProperties();
        return $this->properties[$key] ?? null;
    }

    /**
     * loads the ini file located at a given path
     *
     * @return array
     * @throws FileNotFoundException
     * @throws InvalidPropertyStructureException
     * @throws NoPathException
     */
    private function loadProperties(): array {
        if (null !== $this->properties) {
            return $this->properties;
        }
        if (null === $this->path) {
            throw new NoPathException();
        }
        if (!is_file($this->path)) {
            throw new FileNotFoundException();
        }
        $ini = parse_ini_file($this->path);
        if (false === $ini) {
            throw new InvalidPropertyStructureException();
        }
        $this->properties = $ini;
        return $ini;
    }

    /**
     * returns the number of properties
     *
     * @return int
     */
    public function size(): int {
        $properties = $this->loadProperties();
        return count($properties);
    }

    /**
     * returns the key set of the properties
     *
     * @return array
     */
    public function keySet(): array {
        $array = $this->loadProperties();
        return array_keys($array);
    }

}
