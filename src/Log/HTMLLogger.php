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
 * Class HTMLLogger
 *
 * TODO add other log levels
 *
 * @package doganoo\PHPUtil\Log
 */
class HTMLLogger extends Logger {

    private static $path = null;

    /**
     * Logger constructor prevents class instantiation
     */
    private function __construct() {
    }

    /**
     * logs a message with log level INFO
     *
     * @param $message
     */
    public static function info($message) {
        parent::setConfig(HTMLLogger::getConfiguration());
        parent::info($message);
    }

    private static function getConfiguration(): array {
        return array(
            'appenders'  => array(
                'default' => array(
                    'class'  => 'LoggerAppenderEcho',
                    'layout' => array(
                        'class' => 'LoggerLayoutHtml',
                    )
                )
            ),
            'rootLogger' => array(
                'appenders' => array('default')
            ),
        );
    }

    /**
     * returns the log path
     *
     * @return string
     */
    public static function getPath(): string {
        return self::$path;
    }

    /**
     * sets the log path
     *
     * @param string $path
     */
    public static function setPath(string $path) {
        self::$path = $path;
    }

    /**
     * logs a message with log level WARN
     *
     * @param $message
     */
    public static function warn($message) {
        parent::setConfig(HTMLLogger::getConfiguration());
        parent::warn($message);
    }

    /**
     * logs a message with log level ERROR
     *
     * @param $message
     */
    public static function error($message) {
        parent::setConfig(HTMLLogger::getConfiguration());
        parent::error($message);
    }

    /**
     * logs a message with log level FATAL
     *
     * @param $message
     */
    public static function fatal($message) {
        parent::setConfig(HTMLLogger::getConfiguration());
        parent::fatal($message);
    }

    /**
     * logs a message with log level TRACE
     *
     * @param $message
     */
    public static function trace($message) {
        parent::setConfig(HTMLLogger::getConfiguration());
        parent::trace($message);
    }

    /**
     * logs a message with log level DEBUG
     *
     * @param $message
     */
    public static function debug($message) {
        parent::setConfig(HTMLLogger::getConfiguration());
        parent::debug($message);
    }


}