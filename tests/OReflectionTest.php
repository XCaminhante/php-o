<?php
#@+leo-ver=5-thin
#@+node:caminhante.20230706212234.3: * @file OReflectionTest.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20230724210334.1: ** /include
include_once realpath(__DIR__)."/../O.php";
#@+node:caminhante.20230724210451.1: ** class OReflectionTest
class OReflectionTest extends PHPUnit_Framework_TestCase {
#@+others
#@+node:caminhante.20230724210510.1: *3* testClassComment
public function testClassComment() {
  $reflection = new O\ReflectionClass("ReflectionTest1");
  $this->assertEquals("@package Example", $reflection->getDocComment(TRUE));
  $reflection = new O\ReflectionClass("ReflectionTest2");
  $this->assertEquals("@package Example", $reflection->getDocComment(TRUE));
}
#@+node:caminhante.20230724210525.1: *3* testFakePropertyException
/**
 * @expectedException ReflectionException
 */
public function testFakePropertyException() {
  $reflection = new O\ReflectionClass("ReflectionTest1");
  $reflection->getProperty("nosuchprop");
}
#@+node:caminhante.20230724210534.1: *3* testPropertyComment
public function testPropertyComment() {
  $reflection = new O\ReflectionClass("ReflectionTest1");
  $property = $reflection->getProperty("test");
  $this->assertEquals("@var string", $property->getDocComment(TRUE));
}
#@+node:caminhante.20230724210545.1: *3* testMethodComment
public function testMethodComment() {
  $reflection = new O\ReflectionClass("ReflectionTest1");
  $method = $reflection->getMethod("test");
  $this->assertGreaterThan(0, O\s($method->getDocComment())->pos("@param string \$two"));
}
#@+node:caminhante.20230724210554.1: *3* testMethodParameter
public function testMethodParameter() {
  $reflection = new O\ReflectionClass("ReflectionTest1");
  $method = $reflection->getMethod("test");
  $param = $method->getParameter("two");
  $this->assertNotNull($param);
  $this->assertEquals("@param string \$two", $param->getDocComment());
  $param = $method->getParameter("one");
  $this->assertNotNull($param);
  $this->assertNotSame(FALSE, O\s($param->getDocComment())->pos("@param int \$one"));
  $this->assertNotSame(FALSE, O\s($param->getDocComment())->pos("Some text"));
}
#@+node:caminhante.20230724210602.1: *3* testGetType
public function testGetType() {
  $reflection = new O\ReflectionClass("ReflectionTest3");
  $this->assertEquals("string", $reflection->getProperty("test")->getType());
  $this->assertEquals("string[]", $reflection->getProperty("test2")->getType());
  $this->assertEquals("array[int]string", $reflection->getProperty("test3")->getType());
}
#@-others
}
#@+node:caminhante.20230724210401.1: ** class ReflectionTest1
/**
 * @package Example
 */
class ReflectionTest1 {
/** @var string */
public $test = "foo";
/**
 * @param int $one
 * Some text
 * @param string $two
 */
public function test($one, $two = "") {}
}
#@+node:caminhante.20230724210353.1: ** class ReflectionTest2
/** @package Example */
class ReflectionTest2 { }
#@+node:caminhante.20230724210355.1: ** class ReflectionTest3
class ReflectionTest3 {
/** @var string */
public $test;
/** @var string[] test*/
public $test2;
/**
 * @var array[int]string
 */
public $test3;
}
#@-others
#@-leo
