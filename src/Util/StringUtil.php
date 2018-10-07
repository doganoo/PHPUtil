<?php
/**
 * MIT License
 * Copyright (c) 2018 Dogan Ucar, <dogan@dogan-ucar.de>
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
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
 * Class StringUtil
 *
 * @package doganoo\PHPUtil\Util
 */
final class StringUtil{
	/**
	 * prevent from instantiation
	 * StringUtil constructor.
	 */
	private function __construct(){
	}

	/**
	 * returns an array of elements of the string
	 *
	 * @param null|string $string
	 *
	 * @return array
	 */
	public static function stringToArray(?string $string): array{
		$result = [];
		$strLen = \strlen($string);
		if(null === $string) return $result;
		if(1 === $strLen){
			$result[] = $string;
			return $result;
		}
		for($i = 0; $i < $strLen; $i ++){
			$result[] = $string[$i];
		}
		return $result;
	}

	/**
	 * @param string $string
	 *
	 * @return string
	 */
	public function toUTF8(string $string): string{
		$string = iconv('ASCII', 'UTF-8//IGNORE', $string);
		return $string;
	}

	/**
	 * @param string $string
	 *
	 * @return string
	 */
	public function getEncoding(string $string): string{
		return \mb_detect_encoding($string, "auto", true);
	}
}