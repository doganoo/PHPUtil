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

namespace doganoo\PHPUtil\Service;

use function filter_var;
use function strlen;
use const FILTER_VALIDATE_EMAIL;

class User {

    public const PASSWORD_VALIDATION_UNSAFE = 1;
    public const PASSWORD_VALIDATION_BASIC  = 2;
    public const PASSWORD_VALIDATION_SECURE = 3;

    public function validEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validatePassword(string $password, int $mode = self::PASSWORD_VALIDATION_SECURE): bool {

        if ($mode === User::PASSWORD_VALIDATION_UNSAFE) {
            return $this->validatePasswordUnsafe($password);
        } else if ($mode === User::PASSWORD_VALIDATION_BASIC) {
            return $this->validatePasswordBasic($password);
        } else {
            return $this->validatePasswordSecure($password);
        }
    }

    private function validatePasswordUnsafe(string $password): bool {
        return strlen($password) >= 8;
    }

    private function validatePasswordBasic(string $password): bool {
        $valid = $this->validatePasswordUnsafe($password);
        $valid = $valid && ((bool) preg_match("(^(?=.*[a-z])(?=.*[A-Z]).+$)", $password));
        return $valid;
    }

    private function validatePasswordSecure(string $password): bool {
        $valid = $this->validatePasswordUnsafe($password);
        return $valid && ((bool) preg_match("(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$)", $password));
    }

}
