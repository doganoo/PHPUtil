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

namespace doganoo\PHPUtil\HTTP;

/**
 * Class URLGenerator
 *
 * @package doganoo\PHPUtil\HTTP
 */
class URLGenerator {
    private $hostName = "localhost";
    private $path;
    private $secure = true;

    /**
     * URLGenerator constructor.
     *
     * @param string $hostName
     * @param bool   $secure
     */
    public function __construct(string $hostName, bool $secure = true) {
        $this->hostName = $hostName;
        $this->secure = $secure;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path) {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->getURL();
    }

    /**
     * @return string
     */
    public function getURL(): string {
        $protocol = "http";
        if ($this->secure) {
            $protocol .= "s";
        }
        return "$protocol://{$this->hostName}/{$this->path}";
    }

}