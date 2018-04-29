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

namespace doganoo\PHPUtil\Classloader;

/**
 * Class Autoloader
 *
 * @package doganoo\PHPUtil\Classloader
 */
class Autoloader {
    /**
     * @var string the path where the auto loader should look up
     */
    private $path = null;

    /**
     * Autoloader constructor.
     *
     * @param string $path the path where the auto loader should look up
     */
    public function __construct($path = __DIR__) {
        $this->path = $path;
    }

    /**
     * registers the auto loader
     *
     * TODO register custom autoloaders
     */
    public function register() {
        spl_autoload_register(array(
            $this,
            'loadCore',
        ));
    }

    /**
     * @param $className
     */
    private function loadCore($className) {
        $parts = explode('\\', $className);
        $clazzName = end($parts);
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path), \RecursiveIteratorIterator::SELF_FIRST);

        /**
         * @var string        $key
         * @var  \SplFileInfo $path
         */
        foreach ($iterator as $key => $path) {
            if ($path->isDir()) {
                continue;
            }
            if ("$clazzName.php" === $path->getFilename()) {
                require_once $path->getRealPath();
                break;
            }
        }
    }
}