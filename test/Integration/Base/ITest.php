<?php


namespace doganoo\PHPUtil\IntegrationTest\Base;


interface ITest {

    public function setUp(): void;

    public function run(): bool;

    public function tearDown(): void;

}