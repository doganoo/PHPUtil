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

namespace doganoo\PHPUtil\Util;

/**
 * Class DateTimeUtil
 *
 * @package doganoo\PHPUtil\Util
 */
final class DateTimeUtil {
    /** @var string $GERMAN_DATE_TIME_FORMAT */
    public const GERMAN_DATE_TIME_FORMAT = "d.m.Y H:i:s";

    /**
     * prevent from instantiation
     * StringUtil constructor.
     */
    private function __construct() {
    }

    /**
     * @return int
     * @throws \Exception
     */
    public static function getUnixTimestamp(): int {
        return (new \DateTime())->getTimestamp();
    }

    /**
     * @param int $hours
     * @param \DateTime|null $dateTime
     * @return \DateTime
     * @throws \Exception
     */
    public static function subtractHours(int $hours, \DateTime $dateTime = null): \DateTime {
        if (null === $dateTime) $dateTime = new \DateTime();
        $dateTime->modify("-$hours hours");
        return $dateTime;
    }

    /**
     * returns a string in dd.mm.YYY H:i:s that correspondents to $timestamp
     *
     * @param int $timestamp
     * @return string
     * @throws \Exception
     */
    public static function timestampToGermanDateFormat(int $timestamp): string {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($timestamp);
        $format = $dateTime->format(DateTimeUtil::GERMAN_DATE_TIME_FORMAT);
        return $format;
    }

    /**
     * Whether string is a valid date or not
     *
     * @param string $date
     * @param string $format
     * @return bool
     */
    public static function valid(string $date, string $format): bool {
        return date($format, strtotime($date)) === $date;

    }
}