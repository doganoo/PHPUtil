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
 * @package doganoo\PHPUtil\Log
 */
class Logger {

    /** @var int DEBUG log level 0 */
    public const DEBUG = 10000;
    /** @var int INFO log level 1 */
    public const INFO = 20000;
    /** @var int WARN log level 2 */
    public const WARN = 30000;
    /** @var int ERROR log level 3 */
    public const ERROR = 40000;
    /** @var int FATAL log level 4 */
    public const FATAL = 50000;
    /** @var int TRACE log level 5 */
    public const TRACE = 5000;
    /** @var int OFF */
    const OFF = 2147483647;
    /** @var int SIMPLE */
    public const SIMPLE = 0;
    /** @var int NORMAL */
    public const NORMAL = 1;
    /** @var int DESCRIPTIVE */
    public const DESCRIPTIVE = 2;
    public const ECHO = 0;
    /** @var int $level */
    private static $level = self::ERROR;
    /** @var string $EOL */
    private static $EOL = "\n";
    /** @var int $mode */
    private static $mode = Logger::SIMPLE;
    private static $config = null;


    /**
     * Logger constructor prevents class instantiation
     */
    private function __construct() {
    }

    /**
     * sets the end of line after a message is logged
     *
     * @param string $eol
     * @deprecated
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
        if ($logEnabled) {
            self::setLogLevel(self::$level);
        } else {
            self::setLogLevel(Logger::OFF);
        }
    }

    /**
     * setting the log level.
     *
     * @param int $level
     */
    public static function setLogLevel(int $level): void {
        self::$level = $level;
    }

    /**
     * @param int $mode
     * @return bool
     * @deprecated
     */
    public static function setMode(int $mode): bool {
        if ($mode === Logger::SIMPLE
            || $mode === Logger::NORMAL
            || $mode === Logger::DESCRIPTIVE
        ) {
            Logger::$mode = $mode;
            return true;
        }
        return false;
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
     * @param int $level
     */
    private static function log(string $message, int $level) {
        \Logger::configure(self::getConfiguration());
        $logger = \Logger::getRootLogger();
        $logger->setLevel(self::getLoggerLevel());

        switch ($level) {
            case Logger::DEBUG:
                $logger->debug($message);
                break;
            case Logger::INFO:
                $logger->info($message);
                break;
            case Logger::WARN:
                $logger->warn($message);
                break;
            case Logger::ERROR:
                $logger->error($message);
                break;
            case Logger::FATAL:
                $logger->fatal($message);
                break;
            case Logger::TRACE:
                $logger->trace($message);
                break;
            default:
        }
    }

    private static function getConfiguration(): array {
        if (null === Logger::$config) return Logger::getDefaultConfiguration();
        return Logger::$config;
    }

    private static function getDefaultConfiguration() {
        return array(
            'appenders' => array(
                'default' => array(
                    'class' => 'LoggerAppenderEcho',
                    'layout' => array(
                        'class' => 'LoggerLayoutPattern',
                        'params' => array(
                            'conversionPattern' => '%date{Y-m-d H:i:s} %logger %-5level %msg%n'
                        )
                    )
                )
            ),
            'rootLogger' => array(
                'appenders' => array('default')
            ));
    }

    private static function getLoggerLevel(): \LoggerLevel {
        if (self::$level === self::DEBUG) {
            return \LoggerLevel::getLevelDebug();
        } else if (self::$level === self::INFO) {
            return \LoggerLevel::getLevelInfo();
        } else if (self::$level === self::WARN) {
            return \LoggerLevel::getLevelWarn();
        } else if (self::$level === self::ERROR) {
            return \LoggerLevel::getLevelError();
        } else if (self::$level === self::FATAL) {
            return \LoggerLevel::getLevelFatal();
        } else if (self::$level === self::TRACE) {
            return \LoggerLevel::getLevelTrace();
        } else if (self::$level === self::OFF) {
            return \LoggerLevel::getLevelOff();
        } else {
            return \LoggerLevel::getLevelAll();
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

    /**
     * logs a message with log level TRACE
     *
     * @param $message
     */
    public static function trace($message) {
        self::log($message, Logger::TRACE);
    }

    /**
     * @param array $config
     * @return array
     */
    public static function setConfig(array $config): array {
        return Logger::$config = $config;
    }

}