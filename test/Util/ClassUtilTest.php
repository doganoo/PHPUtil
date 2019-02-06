<?php

use doganoo\PHPAlgorithms\Datastructure\Lists\ArrayLists\ArrayList;
use doganoo\PHPUtil\Util\ClassUtil;
use PHPUnit\Framework\TestCase;

class ClassUtilTest extends TestCase {

    /**
     * @throws ReflectionException
     */
    public function testGetParentClasses() {
        $parentClasses = ClassUtil::getAllParentClasses("", true);
        $this->assertNull($parentClasses);

        $parentClasses = ClassUtil::getAllParentClasses(new X(), true);
        $this->assertInstanceOf(ArrayList::class, $parentClasses);

        $parentClasses = ClassUtil::getAllParentClasses(new Y(), false);

        foreach ($parentClasses as $class) {
            $this->assertTrue($class === X::class);
        }

        $parentClasses = ClassUtil::getAllParentClasses(new Z(), false);

        foreach ($parentClasses as $class) {
            $this->assertTrue($class === X::class || $class === Y::class);
        }

        $parentClasses = ClassUtil::getAllParentClasses(new Y(), true);

        /** @var ReflectionClass $class */
        foreach ($parentClasses as $class) {
            $this->assertTrue($class->getName() === X::class);
        }

        $parentClasses = ClassUtil::getAllParentClasses(new Z(), true);

        /** @var ReflectionClass $class */
        foreach ($parentClasses as $class) {
            $this->assertTrue($class->getName() === X::class || $class->getName() === Y::class);
        }
    }
}

class X {

}

class Y extends X {

}

class Z extends Y {

}