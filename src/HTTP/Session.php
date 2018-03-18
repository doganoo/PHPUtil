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
 * Class Session
 *
 * @package doganoo\PHPUtil\HTTP
 */
class Session {
    /**
     * Session constructor.
     */
    public function __construct() {
        /**
         * see: https://stackoverflow.com/a/17399989
         */
        if (session_id() == '' || !isset ($_SESSION)) {
            session_start();
        }
    }

    /**
     * reads an array from the session
     *
     * @param $index
     * @return array
     */
    public function readArray($index) {
        return isset ($_SESSION [$index]) && is_array($_SESSION [$index]) ? $_SESSION [$index] : [];
    }

    /**
     * sets an array to the session
     *
     * @param $index
     * @param $value
     */
    public function setArray($index, $value) {
        $_SESSION [$index] [] = $value;
    }

    /**
     * destroys the whole session
     */
    public function destroy() {
        session_unset();
        session_destroy();
        $_SESSION = array();
        setcookie(session_name(), "", 0, "/");
    }

    /**
     * deletes an value in the session
     *
     * @param $index
     */
    public function unset($index) {
        unset ($_SESSION [$index]);
    }

    /**
     * returns the session name
     *
     * @return string
     */
    public function getName() {
        return session_name();
    }

    /**
     * reads an index from the session
     *
     * @param $index
     * @return string
     */
    public function read($index) {
        return isset ($_SESSION [$index]) ? trim($_SESSION [$index]) : "";
    }

    /**
     * sets an session element
     *
     * @param $index
     * @param $value
     */
    public function set($index, $value) {
        $_SESSION [$index] = $value;
    }

    /**
     * regenerates the session
     */
    public function regenerateSessionId() {
        session_regenerate_id(true);
    }
}