<?php
#@+leo-ver=5-thin
#@+node:caminhante.20230706212234.1: * @file OValidatorTest.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20230724211249.1: ** /include
include_once realpath(__DIR__)."/../src/O/Validator.php";
#@+node:caminhante.20230724211513.1: ** class OValidatorTest
class OValidatorTest extends PHPUnit_Framework_TestCase {
#@+others
#@+node:caminhante.20230724211543.1: *3* testAnnotations
public function testAnnotations() {
  $reflection = new O\ReflectionClass("ValidationTest1");
  $property = $reflection->getProperty("test");
  $comment = $property->getDocComment(TRUE);
  $annotations = O\Validator::getAnnotations($comment);
  $this->assertEquals("array", gettype($annotations));
  $this->assertEquals(3, count($annotations));
  $this->assertTrue($annotations["NotNull"]);
  $this->assertEquals(10, $annotations["Max"]);
  $this->assertTrue(is_array($annotations["Size"]));
  $vars = $annotations["Size"];
  $this->assertEquals(2, count($vars));
  $this->assertEquals(2, $vars["min"]);
  $this->assertEquals(10, $vars["max"]);
}
#@+node:caminhante.20230724211549.1: *3* testNull
public function testNull() {
  $result = O\Validator::validateValue("ValidationTest_Null", "test", NULL);
  $this->assertEquals("array", gettype($result));
  $this->assertEquals(0, count($result));
  $result = O\Validator::validateValue("ValidationTest_Null", "test", "notnull");
  $this->assertEquals("array", gettype($result));
  $this->assertEquals(1, count($result));
}
#@+node:caminhante.20230724211555.1: *3* testNotNull
public function testNotNull() {
  $obj = new ValidationTest_NotNull();
  $obj->test = "foo";
  $result = O\Validator::validateProperty($obj, "test");
  $this->assertEquals("array", gettype($result));
  $this->assertEquals(0, count($result));
  $obj->test = NULL;
  $result = O\Validator::validateProperty($obj, "test");
  $this->assertEquals("array", gettype($result));
  $this->assertEquals(1, count($result));
  $this->assertEquals("NotNull", $result[0]->constraint);
  $this->assertTrue($result[0]->rootObject === $obj);
}
#@+node:caminhante.20230724211601.1: *3* testNotEmpty
public function testNotEmpty() {
  $obj = new ValidationTest_NotEmpty();
  $obj->test = "test";
  $result = O\Validator::validateProperty($obj, "test");
  $this->assertEquals("array", gettype($result));
  $this->assertEquals(0, count($result));
  $obj->test = "  ";
  $result = O\Validator::validateProperty($obj, "test");
  $this->assertEquals("array", gettype($result));
  $this->assertEquals(1, count($result));
  $this->assertEquals("NotEmpty", $result[0]->constraint);
  $this->assertTrue($result[0]->rootObject === $obj);
  
  $obj = new ValidationTest_NotEmpty_Array();
  $obj->test = array("");
  $result = O\Validator::validateProperty($obj, "test");
  $this->assertEquals("array", gettype($result));
  $this->assertEquals(0, count($result));
  $obj->test = array();
  $result = O\Validator::validateProperty($obj, "test");
  $this->assertEquals("array", gettype($result));
  $this->assertEquals(1, count($result));
  $this->assertEquals("NotEmpty", $result[0]->constraint);
  $this->assertTrue($result[0]->rootObject === $obj);
}
#@+node:caminhante.20230724211607.1: *3* testAssertTrue
function testAssertTrue() {
  $obj = new ValidationTest_AssertTrue();
  $obj->test = TRUE;
  $result = O\Validator::validate($obj);
  $this->assertEquals("array", gettype($result));
  $this->assertEquals(0, count($result));
  $obj->test = FALSE;
  $result = O\Validator::validate($obj);
  $this->assertEquals("array", gettype($result));
  $this->assertEquals(1, count($result));
}
#@+node:caminhante.20230724211615.1: *3* testMin
function testMin() {
  $obj = new ValidationTest_Min();
  $obj->test = array(0, 1, 4);
  $this->assertEquals(0, count(O\Validator::validate($obj)));
  $obj->test[] = -1;
  $this->assertEquals(1, count(O\Validator::validate($obj)));
}
#@+node:caminhante.20230724211622.1: *3* testValid
function testValid() {
  $obj = new ValidationTest_Valid();
  $obj2 = new ValidationTest_NotNull();
  $obj2->test = "foo";
  $obj->test = $obj2;
  $this->assertEquals(0, count(O\Validator::validate($obj)));
  $obj2->test = NULL;
  $this->assertEquals(1, count(O\Validator::validate($obj)));
}
#@+node:caminhante.20230724211643.1: *3* testArrayValid
function testArrayValid() {
  $obj = new ValidationTest_Valid();
  $obj->test = new ValidationTest_NotNull();
  $obj->test->test = "foo";
  $this->assertEquals(0, count(O\Validator::validate($obj)));
  $obj->arrayVal = NULL;
  $this->assertEquals(1, count(O\Validator::validate($obj)));
  $obj->arrayVal = array(new ValidationTest_NotNull());
  $this->assertEquals(1, count(O\Validator::validate($obj)));
  $obj->arrayVal[0]->test = "foo";
  $this->assertEquals(0, count(O\Validator::validate($obj)));
}
#@+node:caminhante.20230724211648.1: *3* testDecimalMin
function testDecimalMin() {
  $obj = new ValidationTest_DecimalMin();
  $obj->test = "3.1415926";
  $this->assertEquals(0, count(O\Validator::validate($obj)));
  $obj->test = "2.9999999";
  $this->assertEquals(1, count(O\Validator::validate($obj)));
}
#@+node:caminhante.20230724211654.1: *3* testDigits
function testDigits() {
  $obj = new ValidationTest_Digits();
  $obj->test = "3.1415";
  $this->assertEquals(0, count(O\Validator::validate($obj)));
  $obj->test = "3.141";
  $this->assertEquals(1, count(O\Validator::validate($obj)));
  $obj->test = "30.1415";
  $this->assertEquals(1, count(O\Validator::validate($obj)));
}
#@+node:caminhante.20230724211658.1: *3* testFuture
function testFuture() {
  $obj = new ValidationTest_Future();
  $obj->test = mktime() + 3600;
  $this->assertEquals(0, count(O\Validator::validate($obj)));
  $obj->test = mktime() - 1;
  $this->assertEquals(1, count(O\Validator::validate($obj)));
}
#@+node:caminhante.20230724211702.1: *3* testPast
function testPast() {
  $obj = new ValidationTest_Past();
  $obj->test = mktime() - 1;
  $this->assertEquals(0, count(O\Validator::validate($obj)));
  $obj->test = mktime() + 3600;
  $this->assertEquals(1, count(O\Validator::validate($obj)));
}
#@+node:caminhante.20230724211728.1: *3* testPattern
function testPattern() {
  $obj = new ValidationTest_Pattern();
  $obj->test = "prefix-valid";
  $this->assertEquals(0, count(O\Validator::validate($obj)));
  $obj->test = "noprefix-invalid";
  $this->assertEquals(1, count(O\Validator::validate($obj)));
}
#@-others
}
#@+node:caminhante.20230724211304.1: ** class ValidationTest_Pattern
class ValidationTest_Pattern {
/**
 * @Pattern(regex=/^prefix-/)
 */
public $test;
}
#@+node:caminhante.20230724211851.1: ** class ValidationTest_Past
class ValidationTest_Past {
/**
 * @Past
 */
public $test;
}
#@+node:caminhante.20230724211308.1: ** class ValidationTest_Future
class ValidationTest_Future {
  /**
   * @Future
   */
  public $test;
}
#@+node:caminhante.20230724211310.1: ** class ValidationTest_Digits
class ValidationTest_Digits {
  /**
   * @Digits(decimals=1,fraction=4)
   */
  public $test;
}
#@+node:caminhante.20230724211314.1: ** class ValidationTest_DecimalMin
class ValidationTest_DecimalMin {
/**
 * @var string
 * @DecimalMin(3)
 */
public $test;
}
#@+node:caminhante.20230724211318.1: ** class ValidationTest_Valid
class ValidationTest_Valid {
/**
 * @var ValidationTest_NotNull
 * @Valid
 */
public $test;
/**
 * @var ValidationTest_NotNull[]
 * @NotNull
 * @Valid
 */
public $arrayVal = array();
}
#@+node:caminhante.20230724211322.1: ** class ValidationTest_Min
class ValidationTest_Min {
/**
 * @var int[]
 * @Min(0)
 */
public $test;
}
#@+node:caminhante.20230724211324.1: ** class ValidationTest_AssertTrue
class ValidationTest_AssertTrue {
/**
 * @var bool
 * @AssertTrue
 */
public $test;
}
#@+node:caminhante.20230724211327.1: ** class ValidationTest_NotEmpty_Array
class ValidationTest_NotEmpty_Array {
/**
 * @var string[]
 * @NotEmpty
 */
public $test;
}
#@+node:caminhante.20230724211330.1: ** class ValidationTest_NotEmpty
class ValidationTest_NotEmpty {
/**
 * @var string
 * @NotEmpty
 */
public $test;
}
#@+node:caminhante.20230724211333.1: ** class ValidationTest_NotNull
class ValidationTest_NotNull {
/**
 * @var string
 * @NotNull
 */
public $test;
}
#@+node:caminhante.20230724211336.1: ** class ValidationTest_Null
class ValidationTest_Null {
/**
 * @var string
 * @Null
 */
public $test;
}
#@+node:caminhante.20230724211340.1: ** class ValidationTest1
class ValidationTest1 {
/**
 * @var string
 * @NotNull
 * @Max(10)
 * @Size(min=2, max=10)
 */
public $test = "";
}
#@-others
#@-leo
