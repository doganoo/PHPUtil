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

namespace doganoo\PHPUtil\Storage;

use doganoo\PHPUtil\Exception\InvalidCredentialsException;
use doganoo\PHPUtil\Exception\PHPUtilException;
use PDO;
use PDOStatement;

/**
 * Class MySQLConnector
 *
 * @package doganoo\PHPUtil\Storage
 */
class PDOConnector implements IStorageConnector {

    /** @var array $credentials */
    private $credentials = null;
    /** @var PDO $mysqli */
    private $pdo = null;
    /** @var PDOStatement $statement */
    private $statement = null;
    /** @var bool $transactionExists */
    private $transactionExists = false;
    /** @var string|null $schemaName */
    private $schemaName = null;

    /**
     * sets the credentials used to connect against the database
     *
     * @param array $credentials
     */
    public function setCredentials(array $credentials) {
        $this->credentials = $credentials;
        $this->schemaName  = $credentials["dbname"];
    }

    /**
     * @return string|null
     */
    public function getSchema(): ?string {
        return $this->schemaName;
    }

    /**
     * starts a database transaction
     *
     * @return bool
     */
    public function startTransaction(): bool {
        if ($this->transactionExists) {
            return false;
        }
        $started                 = $this->pdo->beginTransaction();
        $this->transactionExists = $started;
        return $started;
    }

    /**
     * commits a started database transaction
     *
     * @return bool
     */
    public function commit(): bool {
        if ($this->transactionExists) {
            $commited                = $this->pdo->commit();
            $this->transactionExists = !$commited;
            return $commited;
        }
        return false;
    }

    /**
     * rolls a started transaction back
     *
     * @return bool
     */
    public function rollback(): bool {
        if ($this->transactionExists) {
            $rolledBack              = $this->pdo->rollBack();
            $this->transactionExists = !$rolledBack;
            return $rolledBack;
        }
        return false;
    }

    /**
     * connects to the database
     *
     * @return bool
     * @throws InvalidCredentialsException
     */
    public function connect(): bool {
        if (!$this->hasMinimumCredentials()) {
            throw new InvalidCredentialsException();
        }
        $host      = $this->credentials["servername"];
        $db        = $this->credentials["dbname"];
        $charSet   = $this->credentials["charset"] ?? 'utf8';
        $dsn       = "mysql:host=$host;dbname=$db;charset=$charSet";
        $this->pdo = new PDO($dsn,
            $this->credentials["username"],
            $this->credentials["password"]
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->pdo !== null;
    }

    /**
     * checks for the minimum required credentials
     *
     * @return bool
     */
    private function hasMinimumCredentials(): bool {
        if (!isset($this->credentials["servername"])) {
            return false;
        }
        if (!isset($this->credentials["username"])) {
            return false;
        }
        if (!isset($this->credentials["password"])) {
            return false;
        }
        if (!isset($this->credentials["dbname"])) {
            return false;
        }
        return true;
    }

    /**
     * prepares a SQL statement
     *
     * @param string $sql
     *
     * @return PDOStatement
     * @throws PHPUtilException
     */
    public function prepare(string $sql): PDOStatement {
        $statement = $this->getConnection()->prepare($sql);
        if ($statement === false) {
            throw new PHPUtilException('cout not prepare');
        }
        $this->statement = $statement;
        return $statement;
    }

    /**
     * returns the connection
     *
     * @return PDO|null
     */
    public function getConnection() {
        if (!$this->hasMinimumCredentials()) {
            return null;
        }
        if (!$this->testConnection()) {
            return null;
        }
        return $this->pdo;
    }

    /**
     * test the connection
     *
     * @return bool
     */
    public function testConnection(): bool {
        if (!$this->hasMinimumCredentials()) {
            return false;
        }
        if ($this->pdo === null) {
            return false;
        }
        if ($this->pdo->errorInfo() === []) {
            return false;
        }
        return true;
    }

    /**
     * disconnects the connection
     *
     * @return bool
     */
    public function disconnect(): bool {
        $this->pdo = null;
        return true;
    }

    /**
     * @param null $name
     *
     * @return string
     */
    public function getLastInsertId($name = null) {
        return $this->pdo->lastInsertId($name);
    }

    /**
     * Binds a parameter to the specified variable name
     *
     * @param string $param
     * @param        $value
     * @param int    $dataType
     * @param null   $length
     * @param null   $driverOptions
     */
    public function bindParam(string $param, $value, $dataType = PDO::PARAM_STR, $length = null, $driverOptions = null) {
        $this->statement->bindParam($param, $value, $dataType, $length, $driverOptions);
    }

}
