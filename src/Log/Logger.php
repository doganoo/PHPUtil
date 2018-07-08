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
 * Class
 *
 * TODO enable custom log format
 * TODO elaborate for abstract static classes/abstract classes with static variables/methods
 *
 * @package doganoo\PHPUtil\Log
 */
class Logger {
    /** @var int DEBUG log level 0 */
    public const DEBUG = 0;
    /** @var int INFO log level 1 */
    public const INFO = 1;
    /** @var int WARN log level 2 */
    public const WARN = 2;
    /** @var int ERROR log level 3 */
    public const ERROR = 3;
    /** @var int FATAL log level 4 */
    public const FATAL = 4;
    /** @var int $level */
    private static $level = 0;
    /** @var string $EOL */
    private static $EOL = "\n";
    /** @var bool $logEnabled */
    private static $logEnabled = true;

    /**
     * Logger constructor prevents class instantiation
     */
    private function __construct() {
    }

    /**
     * sets the end of line after a message is logged
     *
     * @param string $eol
     */
    public static function setEOL(string $eol) {
        self::$EOL = $eol;
    }

    /**
     * defines whether logging is enabled or not. Since this logger class
     * logs on the console, it should be possible to deactivate logging
     * (in production, for example).
     *
     * @param bool $logEnabled
     */
    public static function setLogEnabled(bool $logEnabled): void {
        self::$logEnabled = $logEnabled;
    }

    /**
     * setting the log level. The level can be one of:
     *
     * <ul>0 = DEBUG</ul>
     * <ul>1 = INFO</ul>
     * <ul>2 = WARN</ul>
     * <ul>3 = ERROR</ul>
     * <ul>4 = FATAL</ul>
     *
     * if $level does not match to any of these levels, the
     * log level will be initialized to ERROR (3).
     *
     * @param int $level
     */
    public static function setLogLevel(int $level): void {
        if ($level >= Logger::DEBUG && $level <= Logger::FATAL) {
            self::$level = $level;
        } else {
            self::$level = Logger::ERROR;
        }
    }

    /**
     * logs a message with log level DEBUG
     *
     * @param $message
     */
    public static function debug($message) {
        self::log($message, Logger::DEBUG);
    }

    /**
     * logs a message to the console
     *
     * @param string $message
     * @param int    $level
     */
    private static function log(string $message, int $level) {
        $backTrace = \debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $logLevelDescription = Logger::getLogLevelDescription($level);

        if ($level >= self::$level && self::$logEnabled) {
            echo (new \DateTime())->format("Y-m-d H:i:s");
            echo " : ";
            echo $logLevelDescription;
            echo " : ";
            echo \json_encode($backTrace);
            echo " : ";
            echo $message;
            echo self::$EOL;
        }
    }

    /**
     * returns a string that describes the current log level
     *
     * @param int $level
     * @return string
     */
    private static function getLogLevelDescription(int $level): string {
        if ($level === Logger::DEBUG) {
            return "debug";
        }
        if ($level === Logger::INFO) {
            return "info";
        }
        if ($level === Logger::WARN) {
            return "warn";
        }
        if ($level === Logger::ERROR) {
            return "error";
        }
        if ($level === Logger::FATAL) {
            return "fatal";
        }
    }

    /**
     * logs a message with log level INFO
     *
     * @param $message
     */
    public static function info($message) {
        self::log($message, Logger::INFO);
    }

    /**
     * logs a message with log level WARN
     *
     * @param $message
     */
    public static function warn($message) {
        self::log($message, Logger::WARN);
    }

    /**
     * logs a message with log level ERROR
     *
     * @param $message
     */
    public static function error($message) {
        self::log($message, Logger::ERROR);
    }

    /**
     * logs a message with log level FATAL
     *
     * @param $message
     */
    public static function fatal($message) {
        self::log($message, Logger::FATAL);
    }
}