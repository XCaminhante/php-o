<?php
#@+leo-ver=5-thin
#@+node:caminhante.20230706212234.2: * @file OStringTest.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20230724210720.1: ** /includes
include_once realpath(__DIR__)."/../src/O/StringClass.php";
// used for in_array test
include_once realpath(__DIR__)."/../src/O/ArrayClass.php";
#@+node:caminhante.20230724210743.1: ** /vars
// strlen($utf8string) == 10, s()->len() == 5
$utf8string = json_decode("\"\u03ba\u03cc\u03c3\u03bc\u03b5\"");
#@+node:caminhante.20230724210802.1: ** OStringTest
class OStringTest extends PHPUnit_Framework_TestCase {
#@+others
#@+node:caminhante.20230724210818.1: *3* testPos
public function testPos() {
  $this->assertEquals(4, O\s("testfootest")->pos("foo"));
}
#@+node:caminhante.20230724210825.1: *3* testPosUTF8
public function testPosUTF8() {
  global $utf8string;
  $this->assertEquals(5, O\s($utf8string."test")->pos("test"));
}
#@+node:caminhante.20230724210832.1: *3* testIPos
public function testIPos() {
  $this->assertEquals(4, O\s("testfootest")->ipos("FOO"));
}
#@+node:caminhante.20230724210840.1: *3* testRPos
public function testRPos() {
  $this->assertEquals(3, O\s("12121")->rpos("2"));
}
#@+node:caminhante.20230724210848.1: *3* testRIPos
public function testRIPos() {
  $this->assertEquals(3, O\s("ababa")->ripos("B"));
}
#@+node:caminhante.20230724210856.1: *3* testExplode
public function testExplode() {
  $parts = O\s("12121")->explode("2");
  $this->assertEquals(3, count($parts));
  $parts = O\s("12121")->explode("2", 2);
  $this->assertEquals("121", array_pop($parts));
  // utf8 aware
  global $utf8string;
  $parts = O\s($utf8string)->explode("");
  $this->assertEquals(5, count($parts));
}
#@+node:caminhante.20230724210903.1: *3* testTrim
public function testTrim() {
  $this->assertEquals("test", (string) O\s("  test  ")->trim());
  $this->assertEquals("test", (string) O\s("aatestbb")->trim("ab"));
}
#@+node:caminhante.20230724210926.1: *3* testLRTrim
public function testLRTrim() {
  $this->assertEquals("test  ", (string) O\s("  test  ")->ltrim());
  $this->assertEquals("  test", (string) O\s("  test  ")->rtrim());
}
#@+node:caminhante.20230724210935.1: *3* testPad
public function testPad() {
  global $utf8string;
  $this->assertEquals("0001", (string) O\s("1")->pad(4, "0", STR_PAD_LEFT));
  $paddedString = O\s($utf8string)->pad(7);
  $this->assertEquals(7, O\s($paddedString)->len());
  $this->assertEquals(12, strlen($paddedString));
  $paddedString = O\s($utf8string)->pad(15, $utf8string);
  $this->assertEquals(15, O\s($paddedString)->len());
  $this->assertEquals(30, strlen($paddedString));
}
#@+node:caminhante.20230724210946.1: *3* testLen
public function testLen() {
  global $utf8string;
  $this->assertEquals(5, (string) O\s($utf8string)->len());
}
#@+node:caminhante.20230724210954.1: *3* testCase
public function testCase() {
  $this->assertEquals("A", (string) O\s("a")->toupper());
  $this->assertEquals("a", (string) O\s("A")->tolower());
}
#@+node:caminhante.20230724211004.1: *3* testSubstr
public function testSubstr() {
  $this->assertEquals("foo", (string) O\s("testfootest")->substr(4, 3));
}
#@+node:caminhante.20230724211011.1: *3* testReplace
public function testReplace() {
  $this->assertEquals("aaccaaccaa", (string) O\s("aabbaabbaa")->replace("bb", "cc"));
  $this->assertEquals("aaccaaccaa", (string) O\s("aabbaabbaa")->ireplace("BB", "cc"));
}
#@+node:caminhante.20230724211019.1: *3* testPregMatch
public function testPregMatch() {
  global $utf8string;
  $this->assertEquals(1, O\s($utf8string."foo")->preg_match("/f(oo)/", $matches));
  $this->assertEquals("foo", $matches[0]);
  $this->assertEquals(1, O\s($utf8string."foo")->preg_match("/f(oo)/", $matches, PREG_OFFSET_CAPTURE));
  $this->assertEquals("foo", $matches[0][0]);
  $this->assertEquals(5, $matches[0][1]);
  $this->assertEquals(2, O\s($utf8string."foo foo")->preg_match_all("/f(oo)/", $matches, PREG_OFFSET_CAPTURE | PREG_PATTERN_ORDER));
  $this->assertEquals(5, $matches[0][0][1]);
  $this->assertEquals(2, O\s($utf8string."foo foo")->preg_match_all("/f(oo)/", $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER));
  $this->assertEquals(5, $matches[0][0][1]);
  $this->assertEquals("test", (string) O\s("tefoost")->preg_replace("/foo/", ""));
}
#@+node:caminhante.20230724211027.1: *3* testInArray
public function testInArray() {
  $arr = array("bar", "foo");
  $this->assertEquals(true, O\s("foo")->in_array($arr));
  $this->assertEquals(true, O\s("foo")->in_array(O\a($arr)));
}
#@+node:caminhante.20230724211038.1: *3* testParseType
public function testParseType() {
  $type = O\s("string[]")->parse_type();
  $this->assertTrue(is_object($type));
  $this->assertTrue($type->isArray);
  $this->assertNull($type->key);
  $this->assertEquals("string", $type->value);
  $type = O\s("array[int]string")->parse_type();
  $this->assertTrue($type->isArray);
  $this->assertEquals("int", $type->key);
  $this->assertEquals("string", $type->value);
  $type = O\s("array[]string")->parse_type();
  $this->assertTrue($type->isArray);
  $this->assertNull($type->key);
  $this->assertEquals("string", $type->value);
  $type = O\s("float")->parse_type();
  $this->assertFalse($type->isArray);
  $this->assertNull($type->key);
  $this->assertEquals("float", $type->value);
  $type = O\s("array[]")->parse_type();
  $this->assertTrue($type->isArray);
  $this->assertNull($type->key);
  $this->assertEquals("mixed", $type->value);
}
#@+node:caminhante.20230724211045.1: *3* testJSCharAt
public function testJSCharAt() {
  $this->assertEquals("b", (string) O\s("abc")->charAt(1));
}
#@+node:caminhante.20230724211051.1: *3* testJSIndexOf
public function testJSIndexOf() {
  $this->assertEquals(6, O\s("abcdefcd")->indexOf("cd", 5));
}
#@+node:caminhante.20230724211141.1: *3* testJSMatch
public function testJSMatch() {
  $this->assertNull(O\s("abc")->match("/d/"));
  $matches = O\s("abc123abc678")->match("/[1-3]+([a-c]+)[6-8]+/");
  $this->assertTrue(is_array($matches));
  $this->assertEquals(2, count($matches));
  $this->assertEquals("123abc678", $matches[0]);
  $this->assertEquals("abc", $matches[1]);
}
#@+node:caminhante.20230724211147.1: *3* testJSSplit
public function testJSSplit() {
  $this->assertEquals(1, count(O\s("abc")->split()));
  $this->assertEquals(3, count(O\s("abcbd")->split("b")));
}
#@+node:caminhante.20230724211154.1: *3* testHtml
public function testHtml() {
  $s = O\s("&'\"<>/")->html();
  $this->assertEquals("&amp;&#039;&quot;&lt;&gt;&#x2F;", $s);
}
#@+node:caminhante.20230724211201.1: *3* testScript
public function testScript() {
  $s = json_decode("\"<&\u2028\"");
  $r = O\s($s)->script();
  $this->assertEquals("\"\\u003C\\u0026\\u2028\"", $r);
}
#@+node:caminhante.20230724211211.1: *3* testIterable
public function testIterable() {
  $s = "abc";
  $a = array();
  foreach (O\s($s) as $i) {
    $a[] = $i;
  };
  $this->assertEquals(3, count($a));
  $this->assertEquals("c", $a[2]);
}
#@+node:caminhante.20230724211218.1: *3* testArrayIndexing
public function testArrayIndexing() {
  $s = "abcd";
  $obj = O\s($s);
  $this->assertEquals("c", $obj[2]);
  $obj[2] = "e";
  $this->assertEquals("abed", $obj->raw());
  $this->assertTrue(isset($obj[3]));
  $this->assertFalse(isset($obj[4]));
}
#@+node:caminhante.20230724211224.1: *3* testClear
public function testClear() {
  $s = "abc";
  $obj = O\s($s);
  $this->assertEquals(3, $obj->len());
  $obj->clear();
  $this->assertEquals(0, $obj->len());
}
#@-others
}
#@-others
#@-leo
