<?php

namespace Unit;

use Core\Test;
use PHPUnit\Framework\TestCase;

class TestUnitTest extends TestCase
{
    public function testCallMethodFull()
    {
        $test = new Test();

        $foo = $test->foo();

        $this->assertIsInt($foo);
    }
}