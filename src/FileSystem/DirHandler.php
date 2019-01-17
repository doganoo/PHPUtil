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

namespace doganoo\PHPUtil\FileSystem;

/**
 * Class DirHandler
 *
 * @package doganoo\PHPUtil\FileSystem
 */
class DirHandler {
    private $path = null;

    /**
     * DirHandler constructor.
     * @param string $path
     */
    public function __construct(string $path) {
        $this->setPath($path);
    }

    /**
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path) {
        $this->path = $path;
    }

    /**
     * @param string $fileName
     * @return null|FileHandler
     */
    public function findFile(string $fileName): ?FileHandler {
        return $this->_findFile($this->path, $fileName);
    }

    /**
     * finds a file in the given dir
     *
     * @param $dirName
     * @param $fileName
     * @return string
     */
    private function _findFile(string $dirName, string $fileName): ?FileHandler {
        $dirs = glob($dirName . '*');
        $file = null;
        foreach ($dirs as $d) {
            if (is_file($d)) {
                $pathInfo = \pathinfo($d);
                $pathInfo2 = \pathinfo($fileName);

                if (isset($pathInfo2["extension"])) {
                    $condition = $pathInfo["basename"] === $pathInfo2["basename"];
                } else {
                    $condition = $pathInfo["filename"] === $pathInfo2["filename"];
                }

                if ($condition) {
                    return new FileHandler($dirName . "/" . $pathInfo["basename"]);
                }
            } else if (is_dir($d)) {
                $tmp = $this->_findFile($d . "/", $fileName);
                if (null !== $tmp) {
                    $file = $tmp;
                }
            }
        }
        return $file;
    }

    /**
     * whether the dir is readable
     *
     * @return bool
     */
    public function isReadable(): bool {
        return \is_dir($this->path) && \is_readable($this->path);
    }

    /**
     * whether the dir is writable
     *
     * @return bool
     */
    public function isWritable(): bool {
        return \is_dir($this->path) && \is_writable($this->path);
    }

    /**
     * lists every item in a given dir
     *
     * @return array
     */
    public function list(): array {
        return $this->_list($this->path);
    }

    /**
     * lists every item in a given dir
     *
     * see here: https://stackoverflow.com/a/49066335/1966490
     *
     * @param string $path
     * @return array
     */
    private function _list(string $path): array {
        $result = [];
        $scan = glob($path . '/*');
        foreach ($scan as $item) {
            if (is_dir($item)) {
                $result[basename($item)] = $this->_list($item);
            } else {
                $result[] = basename($item);
            }
        }
        return $result;
    }

    /**
     * @return string|null
     */
    public function toRealPath(): ?string {
        $realpath = \realpath($this->path);
        if (false === $realpath) return null;
        return $realpath;
    }
}