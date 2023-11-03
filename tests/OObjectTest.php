<?php
#@+leo-ver=5-thin
#@+node:caminhante.20230706212234.6: * @file OObjectTest.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20230724205224.1: ** /include
include_once realpath(__DIR__)."/../src/O/ObjectClass.php";
#@+node:caminhante.20230724205345.1: ** class OObjectTest
class OObjectTest extends PHPUnit_Framework_TestCase {
#@+others
#@+node:caminhante.20230724205245.1: *3* testMagicMethods
public function testMagicMethods() {
  $o = O\o(array("foo" => "bar", "fn" => function($a, $b) { return $a.$b; }));
  $this->assertTrue(is_object($o));
  $this->assertEquals("bar", $o->foo);
  $o->foo = "baz";
  $this->assertEquals("baz", $o->foo);
  $this->assertTrue(isset($o->foo));
  unset($o->foo);
  $this->assertFalse(isset($o->foo));
  $this->assertTrue(isset($o->fn));
  /** @noinspection PhpUndefinedMethodInspection */
  $this->assertEquals("test", $o->fn("te","st"));
}
#@+node:caminhante.20230724205257.1: *3* testArrayToType
public function testArrayToType() {
  $o = O\o(array(
    "var1" => "123",
    "var2" => 123,
    "var3" => "12.3",
    "var4" => "0",
    "var5" => array(
      "var1" => 3.14
    )
  ))->cast("ObjectTest1");
  $this->assertTrue(is_object($o));
  $this->assertEquals("ObjectTest1", get_class($o));
  $this->assertEquals(123, $o->var1);
  $this->assertEquals("integer", gettype($o->var1));
  $this->assertEquals("123", $o->var2);
  $this->assertEquals("string", gettype($o->var2));
  $this->assertEquals(12.3, $o->var3);
  $this->assertEquals("double", gettype($o->var3));
  $this->assertFalse($o->var4);
  $this->assertEquals("boolean", gettype($o->var4));    
  $this->assertNotNull($o->var5);
  $this->assertEquals("integer", gettype($o->var5->var1));
  $this->assertEquals(3, $o->var5->var1);
}
#@+node:caminhante.20230724205304.1: *3* testJSONToObject
public function testJSONToObject() {
  $o = O\o('{"key":"value"}')->raw();
  $this->assertTrue(is_object($o));
  $this->assertTrue(isset($o->key));
  $this->assertEquals("value", $o->key);
}
#@+node:caminhante.20230724205309.1: *3* testStaticPropsIgnored
public function testStaticPropsIgnored() {
  ObjectTest2::$var2 = 1;
  $o = O\o(array("var1" => 2))->cast("ObjectTest2");
  $this->assertEquals(1, ObjectTest2::$var2);
  $this->assertEquals(2, $o->var1);
  $o = O\o(array("var1" => 3, "var2" => 3))->cast("ObjectTest2");
  $this->assertEquals(1, ObjectTest2::$var2);
  $this->assertEquals(3, $o->var2);
  $this->assertEquals(3, $o->var1);
}
#@+node:caminhante.20230724205315.1: *3* testClear
public function testClear() {
  $obj = O\o(new ObjectTest1());
  $obj->var1 = 10;
  $this->assertTrue(isset($obj->var1));
  $obj->clear();
  $this->assertFalse(isset($obj->var1));
}
#@+node:caminhante.20230724205328.1: *3* testValidate
public function testValidate() {
  $obj = O\o(new ObjectTest3());
  $this->assertFalse($obj->validate($errors));
  $this->assertInternalType("array", $errors);
  $this->assertEquals(1, count($errors));
  $obj->var1 = 5;
  $this->assertTrue($obj->validate());
}
#@+node:caminhante.20230724205336.1: *3* testConvertDateTime
public function testConvertDateTime() {
  $strISODate = "2011-12-19T22:15:00+01:00";
  $obj = O\o(array("var1" => $strISODate))->cast("ObjectTest4");
  $this->assertTrue(is_object($obj));
  $this->assertTrue(is_subclass_of($obj->var1, "DateTime"));
  $this->assertEquals($strISODate, $obj->var1->format('Y-m-d\TH:i:sP'));
  $obj = O\o(array("var1" => NULL))->cast("ObjectTest4");
  $this->assertTrue(is_object($obj));
  $this->assertNull($obj->var1);
}
#@-others
}
#@+node:caminhante.20230724205417.1: ** class ObjectTest1
class ObjectTest1 {
/**
 * @var int
 */
public $var1;

/**
 * @var string
 */
public $var2;

/**
 * @var float
 */
public $var3;

/**
 * @var boolean
 */
public $var4;

/**
 * @var ObjectTest1
 */
public $var5;
}
#@+node:caminhante.20230724205421.1: ** class ObjectTest2
class ObjectTest2 {
/** @var int */
public $var1 = 0;

/** @var int */
public static $var2 = 0;
}
#@+node:caminhante.20230724205424.1: ** class ObjectTest3
class ObjectTest3 {
/**
 * @var int
 * @Min(1)
 */
public $var1 = 0;
}
#@+node:caminhante.20230724205427.1: ** class ObjectTest4
class ObjectTest4 {
/**
 * @var DateTime
 */
public $var1;
}
#@-others
#@-leo
