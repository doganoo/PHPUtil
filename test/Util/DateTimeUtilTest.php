<?php


use doganoo\PHPUtil\Util\DateTimeUtil;
use PHPUnit\Framework\TestCase;

class DateTimeUtilTest extends TestCase {

    public function testValid(){

        $this->assertTrue(true === DateTimeUtil::valid("2019-01-01", "Y-m-d"));
        $this->assertTrue(false === DateTimeUtil::valid("sfsfsdfs", "Y-m-d"));
        $this->assertTrue(false === DateTimeUtil::valid("-1", "y-m-d"));
        $this->assertTrue(false === DateTimeUtil::valid("2019-02-30", "Y-m-d"));
        $this->assertTrue(true === DateTimeUtil::valid("01-02-2018", "d-m-Y"));
    }

}