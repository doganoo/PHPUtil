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


use doganoo\PHPUtil\Log\Logger;

/**
 * Class HeaderBuilder
 *
 * @package doganoo\PHPUtil\HTTP
 */
class HeaderBuilder {
    /** @var bool $replace */
    private $replace = false;
    /** @var int $statusCode */
    private $responseCode = 200;
    /** @var string $header */
    private $header = "";

    /**
     * writes the header string.
     *
     * @param string $header
     * @return $this
     */
    public function withHeader(string $header) {
        $this->header = $header;
        return $this;
    }

    /**
     * writes the response code.
     *
     * @param int $responseCode
     * @return $this
     */
    public function withResponseCode(int $responseCode) {
        $this->responseCode = $responseCode;
        return $this;
    }

    /**
     * writes whether a available header should be replaced or not
     *
     * @return $this
     */
    public function withReplace() {
        $this->replace = true;
        return $this;
    }

    /**
     * shows the current fields
     */
    public function show() {
        Logger::debug("url:{$this->header}, replace: {$this->replace}, responseCode: {$this->responseCode}");
    }

    /**
     * performs the header
     */
    public function perform() {
        \header($this->header, $this->replace, $this->responseCode);
        die();
    }
}