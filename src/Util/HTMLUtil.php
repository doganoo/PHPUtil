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
 * Class HTMLUtil
 *
 * @package doganoo\PHPUtil\Util
 */
final class HTMLUtil {
    /**
     * prevent from instantiation
     * StringUtil constructor.
     */
    private function __construct() {
    }

    /**
     * @param string $url
     * @return string
     */
    public static function CSSBackground(string $url): string {
        return "background-image: url(\"$url\");";
    }

    /**
     * @param string $type
     * @param string $path
     * @return string
     */
    public static function buildScriptTag(string $type, string $path): string {
        return "<script type='$type' src='$path' ></script >";
    }

    /**
     * @param string $path
     * @return string
     */
    public static function buildCssTag(string $path): string {
        return "<link rel = 'stylesheet' href = '$path' >";
    }

    /**
     * @param string $type
     * @param string $value
     * @return string
     */
    public static function getField(string $type, string $value): string {
        return " $type = '$value' ";
    }

    /**
     * @param string $link
     * @param bool   $newTab
     * @return string
     */
    public static function getHyperReference(string $link, bool $newTab = false): string {
        $newTabString = $newTab ? "target='_blank'" : "";
        return "<a $newTabString href='$link'>";
    }
}