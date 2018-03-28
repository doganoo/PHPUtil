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

namespace doganoo\PHPUtil\Storage;

use doganoo\PHPUtil\Exception\InvalidCredentialsException;

/**
 * Class MySQLConnector
 *
 * @package doganoo\PHPUtil\Storage
 */
class MySQLConnector implements IStorageConnector {
    /** @var array $credentials */
    private $credentials = null;
    /** @var \mysqli $mysqli */
    private $mysqli = null;

    /**
     * sets the credentials used to connect against the database
     *
     * @param array $credentials
     */
    public function setCredentials(array $credentials) {
        $this->credentials = $credentials;
    }

    /**
     * connects to the database
     *
     * @return bool
     * @throws InvalidCredentialsException
     */
    public function connect(): bool {
        if (!$this->hasMinimumCredentials()) {
            throw new InvalidCredentialsException();
        }
        $this->mysqli = new \mysqli(
            $this->credentials["servername"]
            , $this->credentials["username"]
            , $this->credentials["password"]
            , $this->credentials["dbname"]
        );
        return $this->mysqli->connect_error !== null;
    }

    /**
     * checks for the minimum required credentials
     *
     * @return bool
     */
    private function hasMinimumCredentials(): bool {
        if (!isset($this->credentials["servername"])) {
            return false;
        }
        if (!isset($this->credentials["username"])) {
            return false;
        }
        if (!isset($this->credentials["password"])) {
            return false;
        }
        if (!isset($this->credentials["dbname"])) {
            return false;
        }
        return true;
    }

    /**
     * disconnects the connection
     *
     * @return bool
     */
    public function disconnect(): bool {
        $this->mysqli = null;
        return true;
    }

    /**
     * returns the connection
     *
     * @return \mysqli|null
     */
    public function getConnection() {
        if (!$this->hasMinimumCredentials()) {
            return null;
        }
        if (!$this->testConnection()) {
            return null;
        }
        return $this->mysqli;
    }

    /**
     * tests the connection
     *
     * @return bool
     */
    public function testConnection(): bool {
        if (!$this->hasMinimumCredentials()) {
            return false;
        }
        return $this->mysqli !== null || $this->mysqli->connect_error !== null;
    }
}