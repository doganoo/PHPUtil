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
 * Class Util
 * @package doganoo\PHPUtil\HTTP
 */
class Util {

    /**
     * Singleton
     * Util constructor.
     */
    private function __construct() {
        // silence is golden
    }

    /**
     * Singleton
     */
    private function __clone() {
        // silence is golden
    }

    /**
     * returns the server URL
     *
     * @return string|null
     */
    public static function getServerURL() {
        $https      = $_SERVER['HTTPS'] ?? null;
        $protocol   = $https === "on" ? "https" : "http";
        $host       = $_SERVER['HTTP_HOST'] ?? null;
        $requestUri = $_SERVER['REQUEST_URI'] ?? null;

        if (null === $host || null === $requestUri) return null;

        return "$protocol://$host$requestUri";
    }

}