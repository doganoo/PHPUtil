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

namespace doganoo\PHPUtil\System;


namespace Core\Objects;


use doganoo\PHPUtil\Exception\FileNotFoundException;
use doganoo\PHPUtil\Exception\NoPathException;

/**
 * Class SysProperties
 *
 * @package Core\Objects
 */
class SysProperties {
    /**
     * @var null
     */
    private static $path = null;

    /**
     * @param string $path
     */
    public static function setPropertiesPath(string $path) {
        self::$path = $path;
    }

    /**
     * @param string $index
     * @return string
     * @throws FileNotFoundException
     * @throws NoPathException
     */
    public function read(string $index): string {
        $index = \trim($index);
        $properties = $this->getProperties();
        if (isset($properties[$index])) {
            return $properties[$index];
        } else {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * @return array
     * @throws FileNotFoundException
     * @throws NoPathException
     */
    private function getProperties(): array {
        if (self::$path === null) {
            throw new NoPathException();
        }
        if (!\is_file(self::$path)) {
            throw new FileNotFoundException();
        }
        $result = parse_ini_file(self::$path);

        return $result;
    }
}