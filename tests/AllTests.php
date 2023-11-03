<?php
#@+leo-ver=5-thin
#@+node:caminhante.20230706212234.10: * @file AllTests.php
#@@first
#@@language plain
include_once "OStringTest.php";
include_once "OArrayTest.php";
include_once "OObjectTest.php";
include_once "OChainableTest.php";
include_once "OReflectionTest.php";
include_once "OValidatorTest.php";
include_once "OPDOTest.php";
include_once "OPDOMySQLTest.php";
include_once "ODateTimeTest.php";
class AllTests {
public static function suite() {
  $suite = new PHPUnit_Framework_TestSuite('PHPUnit');

  $suite->addTestSuite("OStringTest");
  $suite->addTestSuite("OArrayTest");
  $suite->addTestSuite("OObjectTest");
  $suite->addTestSuite("OChainableTest");
  $suite->addTestSuite("OReflectionTest");
  $suite->addTestSuite("OValidatorTest");
  $suite->addTestSuite("OPDOTest");
  $suite->addTestSuite("OPDOMySQLTest");
  $suite->addTestSuite("ODateTimeTest");

  return $suite;
}}
#@-leo
