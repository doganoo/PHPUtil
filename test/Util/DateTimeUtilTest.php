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

use doganoo\PHPUtil\Util\DateTimeUtil;
use PHPUnit\Framework\TestCase;

class DateTimeUtilTest extends TestCase {

    public function testValid(){

        $this->assertTrue(true === DateTimeUtil::valid("2019-01-01", "Y-m-d"));
        $this->assertTrue(false === DateTimeUtil::valid("sfsfsdfs", "Y-m-d"));
        $this->assertTrue(false === DateTimeUtil::valid("-1", "y-m-d"));
        $this->assertTrue(false === DateTimeUtil::valid("2019-02-30", "Y-m-d"));
        $this->assertTrue(true === DateTimeUtil::valid("01-02-2018", "d-m-Y"));
    }

    public function testFromMysqlDateTime(){
        $dateTimeString = "2019-09-20 19:21:47";
        $dateTime = DateTimeUtil::fromMysqlDateTime($dateTimeString);
        $this->assertTrue($dateTime->format(DateTimeUtil::MYSQL_DATE_TIME_FORMAT) === $dateTimeString);
    }

    public function testFormatMysqlDateTime(){
        $this->assertNull(DateTimeUtil::formatMysqlDateTime(null));
        $dateTimeString = "2019-09-20 19:21:47";
        $dateTime = DateTimeUtil::fromMysqlDateTime($dateTimeString);
        $formatted = DateTimeUtil::formatMysqlDateTime($dateTime);
        $this->assertTrue($formatted === $dateTimeString);
    }

}