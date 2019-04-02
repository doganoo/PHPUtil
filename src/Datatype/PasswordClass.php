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

namespace doganoo\PHPUtil\Datatype;

/**
 * Class PasswordClass
 * @package doganoo\PHPUtil\Datatype
 */
class PasswordClass extends StringClass {
    /** @var string PASSWORD_BCRYPT_NAME */
    public const PASSWORD_BCRYPT_NAME = "PASSWORD_BCRYPT";
    /** @var int $algorithm */
    private $algorithm = PASSWORD_BCRYPT;

    /**
     * PasswordClass constructor.
     * @param $value
     */
    public function __construct($value) {
        parent::__construct($value);
        $this->hash();
    }

    /**
     * hashes the string
     */
    public function hash(): void {
        parent::setValue(password_hash($this->getValue(), $this->getAlgorithm()));
    }

    /**
     * verifies the password
     *
     * @param $password
     * @return bool
     */
    public function verify($password): bool {
        if ($password instanceof StringClass || $password instanceof PasswordClass) {
            return password_verify($password->getValue(), $this->getValue());
        }
        return password_verify($password, $this->getValue());
    }

    /**
     * returns the algorithm
     * @return int
     */
    public function getAlgorithm(): int {
        return $this->algorithm;
    }

    /**
     * returns the algorithm name
     *
     * @return StringClass|null
     */
    public function getAlgorithmName():?StringClass{
        if ($this->getAlgorithm() === PASSWORD_BCRYPT){
            return new StringClass(PasswordClass::PASSWORD_BCRYPT_NAME);
        }
        return null;
    }

    /**
     * sets the algorithm
     *
     * @param int $algorithm
     */
    public function setAlgorithm(int $algorithm): void {
        $this->algorithm = $algorithm;
    }


}