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

namespace doganoo\PHPUtil\Log;

/**
 * Class FileLogger
 *
 * TODO add other log levels
 *
 * @package doganoo\PHPUtil\Log
 */
class FileLogger {
    private static $level = 0;
    private static $path = __DIR__ . "/logfile.log";

    /**
     * Logger constructor prevents class instantiation
     */
    private function __construct() {
    }

    public static function setPath(string $path) {
        self::$path = $path;
    }

    /**
     * logs a message with log level DEBUG
     *
     * @param $message
     */
    public static function debug($message) {
        self::log($message, 1);
    }

    /**
     * logs a message to the console
     *
     * @param string $message
     * @param int    $level
     */
    private static function log(string $message, int $level) {
        $output = "";
        if ($level >= self::$level) {
            $output .= (new \DateTime())->format("Y-m-d H:i:s");
            $output .= " : ";
            $output .= $message;
            $output .= "\n";
            \file_put_contents(self::$path, $output, \FILE_APPEND);
        }
    }

}