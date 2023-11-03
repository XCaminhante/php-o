<?php
#@+leo-ver=5-thin
#@+node:caminhante.20230706212234.8: * @file OChainableTest.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20230724204453.1: ** /include
include_once realpath(__DIR__)."/../O.php";
#@+node:caminhante.20230724204507.1: ** class OChainableTest
class OChainableTest extends PHPUnit_Framework_TestCase {
#@+others
#@+node:caminhante.20230724204524.1: *3* testChainString
public function testChainString() {
  $s = "123fooxxx";
  $r = O\cs($s)->substr(3)->rtrim("x")->raw();
  $this->assertEquals("foo", $r);
}
#@+node:caminhante.20230724204531.1: *3* testTypeTransition
public function testTypeTransition() {
  $s = "ababa";
  $r = O\cs($s)->explode("b")->implode("c")->raw();
  $this->assertEquals("acaca", $r);
}
#@+node:caminhante.20230724204539.1: *3* testImplicitString
public function testImplicitString() {
  $s = "foobar";
  $r = (string) O\cs($s)->substr("3");
  $this->assertEquals("bar", $r);
}
#@+node:caminhante.20230724205104.1: *3* testChainBuiltins
public function testChainBuiltins() {
  $a = new ArrayObject(array("foo", "bar", "baz"));
  /** @noinspection PhpUndefinedMethodInspection */
  $r = O\c($a)->getArrayCopy()->implode()->raw();
  $this->assertEquals("foobarbaz", $r);
}
#@+node:caminhante.20230724205110.1: *3* testArrayForeach
public function testArrayForeach() {
  $arr = array("a", "b", "c");
  $r = "";
  foreach (O\ca($arr) as $s) {
    $r .= $s;
  };
  $this->assertEquals("abc", $r);
}
#@+node:caminhante.20230724205117.1: *3* testDeepNesting
public function testDeepNesting() {
  $s = O\c(O\c(O\cs("test")))->raw();
  $this->assertEquals("test", $s);
}
#@-others
}
#@-others
#@-leo
