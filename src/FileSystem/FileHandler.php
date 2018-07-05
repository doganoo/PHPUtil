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
 * Class FileHandler
 *
 * @package doganoo\PHPUtil\FileSystem
 */
class FileHandler {
    /** @var string $path */
    private $path = null;

    /**
     * FileHandler constructor.
     *
     * @param $path
     */
    public function __construct($path) {
        $this->path = $path;
    }

    /**
     * creates a file
     *
     * @return bool
     */
    public function create(): bool {
        if ($this->isFile()) {
            return \touch($this->path);
        }
        return false;
    }

    /**
     * is a file or not
     *
     * @return bool
     */
    public function isFile(): bool {
        return \is_file($this->path);
    }

    /**
     * forces a file creation
     *
     * @return bool
     */
    public function forceCreate(): bool {
        if (!$this->isFile()) {
            return \mkdir($this->path, 0744, true);
        }
        if ($this->isFile() && !$this->isWritable()) {
            $user = \get_current_user();
            return \chown($this->path, $user);
        }
        return false;
    }

    /**
     * checks whether the file is writable or not
     *
     * @return bool
     */
    public function isWritable(): bool {
        return \is_writable($this->path);
    }

    /**
     * returns the file content if file is available. Otherwise null
     *
     * @return null|string
     */
    public function getContent(): ?string {
        if ($this->isFile()) {
            return \file_get_contents($this->path);
        }
        return null;
    }

}