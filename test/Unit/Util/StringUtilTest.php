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

use doganoo\PHPUtil\Datatype\StringClass;
use PHPUnit\Framework\TestCase;

/**
 * Class StringUtilTest
 */
class StringUtilTest extends TestCase {

    /**
     * test prefix
     */
    public function testPrefix() {
        $string = new StringClass("doganucar");

        $this->assertTrue(true === $string->hasPrefix("dogan"));
        $this->assertTrue(false === $string->hasPrefix("anuc"));
        $this->assertTrue(false === $string->hasPrefix("ucar"));
        $this->assertTrue(false === $string->hasPrefix(""));

    }

    public function testSuffix() {
        $string = new StringClass("doganucar");

        $this->assertTrue(true === $string->hasSuffix("ucar"));
        $this->assertTrue(false === $string->hasSuffix("anuc"));
        $this->assertTrue(false === $string->hasSuffix("dogan"));
        $this->assertTrue(false === $string->hasSuffix(""));

    }

}