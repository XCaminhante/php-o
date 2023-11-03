<?php
#@+leo-ver=5-thin
#@+node:caminhante.20230706212234.9: * @file OArrayTest.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20230724204143.1: ** /include
include_once realpath(__DIR__)."/../src/O/ArrayClass.php";
#@+node:caminhante.20230724204156.1: ** class OArrayTest
class OArrayTest extends PHPUnit_Framework_TestCase {
#@+others
#@+node:caminhante.20230724204231.1: *3* testCount
public function testCount() {
  $arr = array(1, 2, 3);
  $this->assertEquals(3, O\a($arr)->count());
}
#@+node:caminhante.20230724204239.1: *3* testHas
public function testHas() {
  $arr = array(1, 2, 3);
  $this->assertTrue(O\a($arr)->has(2));
  $this->assertTrue(O\a($arr)->has("2"));
  $this->assertFalse(O\a($arr)->has("2", TRUE));
  $this->assertFalse(O\a($arr)->has(0));
}
#@+node:caminhante.20230724204245.1: *3* testSearch
public function testSearch() {
  $arr = array(1, 2, 3);
  $this->assertEquals(1, O\a($arr)->search(2));
}
#@+node:caminhante.20230724204254.1: *3* testShift
public function testShift() {
  $arr = array(1, 2, 3);
  $elem = O\a($arr)->shift();
  $this->assertEquals(1, $elem);
  $this->assertEquals(2, count($arr));
}
#@+node:caminhante.20230724204300.1: *3* testKeyExists
public function testKeyExists() {
  $arr = array("a" => "b");
  $this->assertFalse(O\a($arr)->key_exists("c"));
  $this->assertTrue(O\a($arr)->key_exists("a"));
}
#@+node:caminhante.20230724204306.1: *3* testUnshift
public function testUnshift() {
  $arr = array("a", "b");
  $this->assertEquals(4, O\a($arr)->unshift("c", "d"));
  $this->assertEquals("cdab", implode($arr));
}
#@+node:caminhante.20230724204313.1: *3* testImplode
public function testImplode() {
  $arr = array("a", "b", "c");
  $this->assertEquals("abc", O\a($arr)->implode());
  $this->assertEquals("a b c", O\a($arr)->implode(" "));
}
#@+node:caminhante.20230724204317.1: *3* testKeys
public function testKeys() {
  $arr = array("a" => "b", "c" => "d");
  $this->assertEquals("ac", implode(O\a($arr)->keys()));
}
#@+node:caminhante.20230724204321.1: *3* testValues
public function testValues() {
  $arr = array("a" => "b", "c" => "d");
  $this->assertEquals("bd", implode(O\a($arr)->values()));  
}
#@+node:caminhante.20230724204325.1: *3* testPop
public function testPop() {
  $arr = array("a", "b");
  $this->assertEquals("b", O\a($arr)->pop());
  $this->assertEquals(1, count($arr));
}
#@+node:caminhante.20230724204330.1: *3* testPush
public function testPush() {
  $arr = array("a", "b");
  $this->assertEquals(4, O\a($arr)->push("c", "d"));
  $this->assertEquals("abcd", implode($arr));
}
#@+node:caminhante.20230724204334.1: *3* testSlice
public function testSlice() {
  $arr = array("a", "b", "c", "d");
  $this->assertEquals("bc", implode(O\a($arr)->slice(1, 2)));
}
#@+node:caminhante.20230724204339.1: *3* testSplice
public function testSplice() {
  $arr = array("a", "b", "c", "d");
  $this->assertEquals("bc", implode(O\a($arr)->splice(1, 2)));
  $this->assertEquals("ad", implode($arr));
}
#@+node:caminhante.20230724204343.1: *3* testMerge
public function testMerge() {
  $arr = array("a", "b");
  $arrNew = O\a($arr)->merge(array("c", "d"), array("e", "f"));
  $this->assertEquals("abcdef", implode($arrNew));
  $this->assertEquals("ab", implode($arr));
}
#@+node:caminhante.20230724204347.1: *3* testMap
public function testMap() {
  $arr = array(1, 2, 3);
  $fn = function($v, $s) { return $v*$s; };
  $mapped = O\a($arr)->map($fn, array(2, 3, 0));
  $this->assertEquals(3, O\a($mapped)->count());
  $this->assertEquals(2, $mapped[0]);
  $this->assertEquals(6, $mapped[1]);
}
#@+node:caminhante.20230724204351.1: *3* testReduce
public function testReduce() {
  $arr = array(2, 2, 4);
  $fn = function($a, $b) { return $a+$b; };
  $result = O\a($arr)->reduce($fn, 1);
  $this->assertEquals(9, $result);
}
#@+node:caminhante.20230724204355.1: *3* testSum
public function testSum() {
  $arr = array(1, 1);
  $this->assertEquals(2, O\a($arr)->sum());
}
#@+node:caminhante.20230724204401.1: *3* testForeach
public function testForeach() {
  $arr = array("a", "b", "c");
  $r = "";
  foreach (O\a($arr) as $s) {
    $r .= $s;
  };
  $this->assertEquals("abc", $r);
}
#@+node:caminhante.20230724204410.1: *3* testArrayIndexing
public function testArrayIndexing() {
  $arr = array("a", "b", "c");
  $obj = O\a($arr);
  $this->assertEquals("b", $obj[1]);
  $obj[1] = "d";
  $this->assertEquals("adc", $obj->implode());
  unset($obj[1]);
  $this->assertEquals(2, $obj->count());
  $this->assertTrue(isset($obj[2]));
  $this->assertFalse(isset($obj[3]));
}
#@+node:caminhante.20230724204417.1: *3* testNavigation
public function testNavigation() {
  $arr = array("a", "b", "c");
  $obj = O\a($arr);
  $this->assertEquals("c", $obj->end());
  $this->assertEquals("a", $obj->begin());
  $this->assertEquals("b", $obj->next());
  $this->assertEquals("b", $obj->current());
  $this->assertEquals("c", $obj->next());
  $str = "";
  $obj->begin();
  /** @noinspection PhpUnusedLocalVariableInspection */
  while (list($key, $val) = $obj->each()) {
    $str .= $val;
  };
  $this->assertEquals("abc", $str);
}
#@+node:caminhante.20230724204422.1: *3* testClear
public function testClear() {
  $arr = array("a", "b", "c");
  $obj = O\a($arr);
  $this->assertEquals(3, $obj->count());
  $obj->clear();
  $this->assertEquals(0, $obj->count());
}
#@-others
}
#@-others
#@-leo
