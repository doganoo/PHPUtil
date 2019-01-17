<?php


use doganoo\PHPUtil\FileSystem\DirHandler;
use PHPUnit\Framework\TestCase;

class DirHandlerTest extends TestCase {
    public function testDirHandler() {
        $dirHandler = new DirHandler(__DIR__);
        $fileHandler = $dirHandler->findFile("DirHandlerTest.php");
        $this->assertTrue(null !== $fileHandler);
    }
}