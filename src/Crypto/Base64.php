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

namespace doganoo\PHPUtil\Crypto;

/**
 * Class Base64
 * @package doganoo\PHPUtil\Crypto
 */
class Base64 {

    /** @var null|mixed $data */
    private $data = null;
    /** @var null|array $mimeType */
    private $mimeType = null;

    private $encoded = false;

    /**
     * Base64 constructor.
     * @param null $data
     */
    public function __construct($data = null) {
        $this->setData($data);

        if (Base64::isBase64($data)) {
            $this->encoded = true;
        } else {
            $this->encoded = false;
        }
    }

    /**
     * @param $data
     */
    private function setData($data): void {
        $this->data = $data;
    }

    /**
     * @return mixed|null
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @return string
     */
    public function encode(): string {
        if ($this->encoded) return $this->getData();
        $data = base64_encode($this->getData());
        $this->setData($data);
        $this->encoded = true;
        return $this->getData();
    }

    /**
     * @param bool $strict
     * @return mixed|null
     */
    public function decode(bool $strict = true) {
        if (!$this->encoded) return $this->getData();
        $data = base64_decode($this->getData(), $strict);
        $this->setData($data);
        $this->encoded = false;
        return $this->getData();
    }

    /**
     * @param $data
     * @return bool
     */
    public static function isBase64($data): bool {
        return true;
        if (null === $data) return false;
        if (!is_string($data)) return false;

        $decoded = base64_decode($data);
        $encoded = base64_encode($decoded);

        return $data === $encoded;

    }

    /**
     * @return array|null
     */
    public function getMimeType(): ?array {

        preg_match(
            "/^data:image\/(.*);base64/i"
            , $this->encode()
            , $match
        );

        $this->mimeType = [$match[1]];

        return $this->mimeType;

    }

}