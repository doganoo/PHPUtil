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

    /** @var null|string $content */
    private $content = null;

    /**
     * FileHandler constructor.
     *
     * @param $path
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
    public function setPath(string $path): void {
        $this->path    = $path;
        $this->content = null;
    }

    /**
     * creates a file
     *
     * @param bool $override whether the file should be overriden
     * @return bool
     */
    public function create(bool $override): bool {
        if ($this->isFile() && !$override) return false;
        $handle = @fopen($this->path, 'w');
        if (false === $handle) return false;
        fclose($handle);
        return true;
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
     * checks whether the file is readable or not
     *
     * @return bool
     */
    public function isReadable(): bool {
        return \is_readable($this->path);
    }

    /**
     * alias method of isFile()
     *
     * @return bool
     */
    public function exists(): bool {
        return $this->isFile();
    }

    /**
     * forces a file creation
     *
     * @return bool
     * @deprecated Use create() instead
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
        if (null !== $this->content) return $this->content;
        if (!$this->isFile()) return null;
        $content = \file_get_contents($this->path);
        if (false === $content) return null;
        return $content;
    }

    /**
     * sets the content
     *
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void {
        $this->content = $content;
    }

    /**
     * @return bool
     */
    public function save(): bool {
        if (!$this->isFile()) return false;
        if (!$this->isWritable()) return false;
        return false !== \file_put_contents($this->path, $this->content);
    }

}