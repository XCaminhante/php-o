<?php
//@+leo-ver=5-thin
//@+node:caminhante.20211024200632.7: * @file O.php
//@@first
namespace O;
//@+others
//@+node:caminhante.20211024201242.1: ** class O
class O {
/**
 * Force O functions to get loaded
 */
static function init () {
  $classPath = realpath(__DIR__);
  // Session
  if (!class_exists("\\O\\Session")) { include($classPath."/Session.php"); }
  // s()
  if (!class_exists("\\O\\StringClass")) { include($classPath."/StringClass.php"); }
  // a()
  if (!class_exists("\\O\\ArrayClass")) { include($classPath."/ArrayClass.php"); }
  // o()
  if (!class_exists("\\O\\ObjectClass")) { include($classPath."/ObjectClass.php"); }
  // c()
  if (!class_exists("\\O\\ChainableClass")) { include($classPath."/ChainableClass.php"); }
  // Validator and ReflectionClass
  if (!class_exists("\\O\\Validator")) { include($classPath."/Validator.php"); }
  // PDO
  if (!class_exists("\\O\\PDO") && extension_loaded("pdo")) { include($classPath."/PDO.php"); }
  // DateTime
  if (!class_exists("\\O\\DateTime")) { include($classPath."/DateTime.php"); }
}}
//@-others
//@-leo
