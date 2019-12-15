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

namespace doganoo\PHPUtil\Mail;

/**
 * Class Validator
 *
 * @package    doganoo\PHPUtil\Mail
 * @deprecated use Service/Regex instead
 */
class Validator {

    /**
     * strips all email adresses out of an string. More information at:
     * https://stackoverflow.com/questions/1028553/how-to-get-email-address-from-a-long-string
     *
     * @param string $dump
     * @return array
     */
    public function stripAddresses(string $dump, bool $unique = true): array {
        $emails = [];
        foreach (preg_split('/\s/', $dump) as $token) {
            $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            if ($email !== false) {
                $emails[] = $email;
            }
        }
        if ($unique) {
            $emails = \array_unique($emails);
        }
        return $emails;
    }

}