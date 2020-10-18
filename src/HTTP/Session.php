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

use JsonSerializable;

/**
 * Class Session
 *
 * @package doganoo\PHPUtil\HTTP
 */
class Session implements JsonSerializable {

    /**
     * starts the session: https://stackoverflow.com/a/17399989
     *
     * @return bool
     */
    public function start(): bool {
        if (false === $this->isStarted()) {
            return session_start();
        }
        return false;
    }

    /**
     * deletes an value in the session
     *
     * @param string $index
     */
    public function remove(string $index): void {
        $_SESSION[$index] = null;
        unset ($_SESSION[$index]);
    }

    /**
     * reads an index from the session
     *
     * @param string $index
     * @param null   $default
     * @return string|null
     */
    public function get(string $index, $default = null): ?string {
        if (isset($_SESSION[$index])) {
            return $_SESSION[$index];
        }

        if (null === $default) {
            return null;
        }

        return $default;
    }

    /**
     * sets an session element
     *
     * @param string $index
     * @param string $value
     */
    public function set(string $index, string $value) {
        $_SESSION[$index] = $value;
    }

    /**
     * regenerates the session
     *
     * @param bool $deleteOldSession
     * @return bool
     */
    public function regenerateSessionId(bool $deleteOldSession = true): bool {
        return session_regenerate_id($deleteOldSession);
    }

    /**
     * @return bool
     */
    public function isStarted(): bool {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * @return array
     */
    public function getAll(): array {
        return $_SESSION;
    }

    /**
     * destroys the whole session
     */
    public function destroy(): void {
        session_unset();
        session_destroy();
        $_SESSION = [];
        setcookie(session_name(), "", 0, "/");
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize() {
        return $this->getAll();
    }

}