<?php namespace O;
#@+leo-ver=5-thin
#@+node:caminhante.20211024200632.4: * @file ReflectionClass.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20230706213034.1: ** /includes
if (!class_exists("\\O\\StringClass")) { include("StringClass.php"); }
#@+node:caminhante.20230706214126.1: ** class ReflectionClass
/**
 * Reflection class with type hinting and extended docblock parsing
 */
class ReflectionClass extends \ReflectionClass {
#@+others
#@+node:caminhante.20230706214157.1: *3* public function getMethods ($filter = NULL)
/**
 * @param int $filter
 * @return \O\ReflectionMethod[]
 */
public function getMethods ($filter = NULL): array {
  $methods = parent::getMethods($filter);
  foreach ($methods as $index => $method) {
    $methods[$index] = new ReflectionMethod(
      $this->getName(), $method->getName());
  };
  return $methods;
}
#@+node:caminhante.20230706214205.1: *3* public function getMethod ($name)
/**
 * @param string $name
 * @return \O\ReflectionMethod
 */
public function getMethod ($name): \ReflectionMethod {
  return new ReflectionMethod($this->getName(), $name);
}
#@+node:caminhante.20230706214220.1: *3* public function getProperties ($filter = NULL)
/**
 * @param int $filter
 * @return \O\ReflectionProperty[]
 */
public function getProperties ($filter = NULL): array {
  if ($filter === NULL) {
    $filter =
      ReflectionProperty::IS_STATIC |
        ReflectionProperty::IS_PUBLIC |
        ReflectionProperty::IS_PROTECTED |
        ReflectionProperty::IS_PRIVATE;
  };
  $properties = parent::getProperties($filter);
  foreach ($properties as $index => $property) {
    $properties[$index] = new ReflectionProperty(
      $this->getName(), $property->getName());
  };
  return $properties;
}
#@+node:caminhante.20230706214229.1: *3* public function getProperty ($name)
/**
 * @param string $name
 * @return \O\ReflectionProperty
 */
public function getProperty ($name): \ReflectionProperty {
  return new ReflectionProperty($this->getName(), $name);
}
#@+node:caminhante.20230706214238.1: *3* public function getDocComment ($onlytext = FALSE)
/**
 * @param bool $onlytext
 * @return string
 */
public function getDocComment ($onlytext = FALSE): string|false {
  $doc = parent::getDocComment();
  if ($onlytext) {
    $doc = s($doc)->preg_replace("/(?<=[\r\n])[\\s]*\*(\ )?(?![\/])/", "");
    $doc = s($doc)->preg_replace("/^[\\s]*\/\*\*[\\s]*[\r\n]*/", "");
    $doc = s($doc)->preg_replace("/[\r\n]*[\\s]*\*\/$/", "");
  };
  return (string) $doc;
}
#@-others
}
#@+node:caminhante.20230706214033.1: ** class ReflectionProperty
class ReflectionProperty extends \ReflectionProperty {
#@+others
#@+node:caminhante.20230706214052.1: *3* public function getDocComment ($onlytext = FALSE)
public function getDocComment ($onlytext = FALSE): string|false {
  $doc = parent::getDocComment();
  if ($onlytext) {
    $doc = s($doc)->preg_replace("/(?<=[\r\n])[\\s]*\*(\ )?(?![\/])/", "");
    $doc = s($doc)->preg_replace("/^[\\s]*\/\*\*[\\s]*[\r\n]*/", "");
    $doc = s($doc)->preg_replace("/[\r\n]*[\\s]*\*\/$/", "");
  };
  return (string) $doc;
}
#@+node:caminhante.20230706214059.1: *3* public function getType ()
public function getType (): ?\ReflectionType {
  $doc = $this->getDocComment();
  $matches = array();
  $pattern = "/\@var[\\s]+([\\S]+)/";
  if (s($doc)->preg_match($pattern, $matches)) {
    return $matches[1];
  } else {
    return NULL;
  }
}
#@-others
}
#@+node:caminhante.20230706213728.1: ** class ReflectionMethod
class ReflectionMethod extends \ReflectionMethod {
#@+others
#@+node:caminhante.20230706213746.1: *3* public function getDocComment ($onlytext = FALSE)
public function getDocComment ($onlytext = FALSE): string|false {
  $doc = parent::getDocComment();
  if ($onlytext) {
    $doc = s($doc)->preg_replace("/(?<=[\r\n])[\\s]*\*(\ )?(?![\/])/", "");
    $doc = s($doc)->preg_replace("/^[\\s]*\/\*\*[\\s]*[\r\n]*/", "");
    $doc = s($doc)->preg_replace("/[\r\n]*[\\s]*\*\/$/", "");
  };
  return (string) $doc;
}
#@+node:caminhante.20230706213941.1: *3* public function getDeclaringClass ()
public function getDeclaringClass (): \ReflectionClass {
  return new ReflectionClass(parent::getDeclaringClass()->getName());
}
#@+node:caminhante.20230706213949.1: *3* public function getParameters ()
public function getParameters (): array {
  $params = parent::getParameters();
  foreach ($params as $index => $param) {
    $params[$index] = new ReflectionParameter(
      array($this->getDeclaringClass()->getName(), $this->getName()),
      $param->getName());
  };
  return $params;
}
#@+node:caminhante.20230706213956.1: *3* public function getParameter ($name)
public function getParameter ($name) {
  return new ReflectionParameter(
    array($this->getDeclaringClass()->getName(), $this->getName()),
    $name);
}
#@-others
}
#@+node:caminhante.20230706213609.1: ** class ReflectionParameter
class ReflectionParameter extends \ReflectionParameter {
#@+others
#@+node:caminhante.20230706213627.1: *3* public function getDocComment ()
public function getDocComment () {
  $methoddoc = $this->getDeclaringFunction()->getDocComment(TRUE);
  $parts = s($methoddoc)->explode("@param");
  for ($i = 1; $i < count($parts); $i++) $parts[$i] = "@param".$parts[$i];
  a($parts)->shift();
  $filter = "/\@param[^\\$]+\\$".$this->getName()."(?![\\w])/";
  foreach ($parts as $part) {
    if (s($part)->preg_match($filter)) {
      return $part;
    };
  };
  return "";
}
#@+node:caminhante.20230706213706.1: *3* public function getDeclaringFunction ()
public function getDeclaringFunction (): \ReflectionFunctionAbstract {
  $f = parent::getDeclaringFunction();
  /** @var $f ReflectionMethod */
  if (is_a($f, "ReflectionMethod")) {
    return new ReflectionMethod($f->getDeclaringClass()->getName(), $f->getName());
  } else {
    return $f;
  }
}
#@-others
}
#@-others
#@-leo
