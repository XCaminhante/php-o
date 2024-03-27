<?php namespace O;
#@+leo-ver=5-thin
#@+node:caminhante.20211024200632.6: * @file ObjectClass.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20211024201450.1: ** /includes
if (!class_exists("\\O\\ReflectionClass")) { include("ReflectionClass.php"); }
if (!class_exists("\\O\\DateTime")) { include("DateTime.php"); }
#@+node:caminhante.20211024201520.1: ** class ObjectClass
/**
 * Supporting class for the o() function
 */
class ObjectClass implements \IteratorAggregate, \ArrayAccess {
private $o;
#@+others
#@+node:caminhante.20231104225648.1: *3* static function obsafe_print_r
public static function obsafe_print_r ($var, $return = false, $html = false, $level = 0) {
  $vts = static function ($v): string {
    if (is_null($v)) { return 'null'; }
    if (is_array($v)) { $c = count($v); return "Array ({$c}) {"; }
    if (is_object($v)) { return get_class($v)." Object {"; }
    if (is_bool($v)) { return $v ? 'true' : 'false'; }
    if (is_string($v)) { return '"' . s($v)->replace('"','\\"') . '"'; }
    if (is_float($v)) { return sprintf("%g",$v); }
    return strval($v);
  };
  $spaces = "";
  $space = $html ? "&nbsp;" : " ";
  $newline = $html ? "<br/>" : "\n";
  $spaces = s($space)->repeat(2);
  $output = $vts($var) . "\n";
  if (is_array($var) || is_object($var)) {
    foreach ($var as $key => $value) {
      if (is_array($value) || is_object($value)) {
        $value = s( ObjectClass::obsafe_print_r($value, true, $html, $level+1) )->substr(0,-1); }
      else {
        $value = $vts($value); }
      $output .= $spaces->repeat($level+1) . "[" . $key . "] = " . $value . $newline;
    }
    $output .= s($spaces)->repeat($level) .  '}' . $newline;
  }
  if ($return) { return $output; } else { echo $output; }
}
#@+node:caminhante.20240321181533.1: *3* static function json_print
public static function json_print ($var) {
  $vts = static function ($v): string {
    if (is_null($v)) { return 'null'; }
    if (is_array($v) || $v instanceof \Countable) { return "["; }
    if (is_object($v)) { return "{"; }
    if (is_bool($v)) { return $v ? 'true' : 'false'; }
    if (is_string($v)) { return '"' . s($v)->replace('"','\\"') . '"'; }
    if (is_float($v)) { return sprintf("%g",$v); }
    return strval($v);
  };
  $output = $vts($var);
  if (is_array($var) || is_object($var)) {
    foreach ($var as $key => $value) {
      if (is_array($value) || is_object($value)) {
        $value = json_print($value);
      } else {
        $value = $vts($value); }
      if (is_array($var) || $var instanceof \Countable) {
        $output .= $value . ',';
      } else {
        $output .= '"' . $key . '":' . $value . ','; }
    }
    $output = s($output)->preg_replace('/,$/m', '');
    if (is_array($var) || $var instanceof \Countable) { $output .= ']'; } else { $output .= '}'; }
  }
  return $output;
}
#@+node:caminhante.20211024201604.1: *3* function __construct
function __construct ($o) {
  if (is_string($o)) $o = json_decode($o);
  if (is_object($o) || is_array($o)) {
    $this->o = (object) $o;
  } else {
    $this->o = NULL;
  }
}
#@+node:caminhante.20211024201627.1: *3* function __toString
function __toString () {
  return ObjectClass::json_print($this->o);
}
#@+node:caminhante.20211024201639.1: *3* function __call
function __call ($fn, $args) {
  if (method_exists($this->o, $fn)) {
    return call_user_func_array(array($this->o, $fn), $args);
  } else if (isset($this->o->$fn)) {
    return call_user_func_array($this->o->$fn, $args);
  } else { return NULL; }
}
#@+node:caminhante.20211024201724.1: *3* function __get
function __get ($prop) {
  return $this->o->$prop;
}
#@+node:caminhante.20211024201728.1: *3* function __set
function __set ($prop, $value) {
  return $this->o->$prop = $value;
}
#@+node:caminhante.20211024201731.1: *3* function __isset
function __isset ($prop) {
  return isset($this->o->$prop);
}
#@+node:caminhante.20211024201734.1: *3* function __unset
function __unset ($prop) {
  unset($this->o->$prop);
}
#@+node:caminhante.20211024201738.1: *3* function cast
function cast ($asType = "stdClass") {
  if ($asType == "stdClass") {
    return $this->o;
  } else {
    if (!class_exists($asType)) { $asType = "O\\".$asType; }
    if (class_exists($asType)) {
      if (is_object($this->o)) {
        $a = (array) $this->o;
        /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
        $refl = new \O\ReflectionClass($asType);
        $props = $refl->getProperties(ReflectionProperty::IS_STATIC|ReflectionProperty::IS_PUBLIC);
        $result = new $asType();
        // convert properties to the right type
        foreach ($props as $prop) {
          $propName = $prop->getName();
          if (isset($a[$propName])) {
            $result->$propName = convertType($a[$propName], $prop->getType());
          }
        }
        return $result;
      } else {
        return NULL;
      }
    } else {
      throw new \Exception("Unrecognized type: ".$asType);
    }
  }
}
#@+node:caminhante.20211024201742.1: *3* function clear
function clear () {
  return $this->o = new \stdClass();
}
#@+node:caminhante.20231104225615.1: *3* function print_r
function print_r ($return = false, $html = false) {
  return ObjectClass::obsafe_print_r($this->o, $return, $html);
}
#@+node:caminhante.20211024201745.1: *3* function raw
function raw () {
  return $this->o;
}
#@+node:caminhante.20211024201751.1: *3* function render
function render ($template) {
  extract((array) $this->o);
  /** @noinspection PhpIncludeInspection */
  include $template;
}
#@+node:caminhante.20211024201755.1: *3* function validate
/**
 * Validate an object using Validator::validate
 * @param Array $errors Variable to return any found errors in, optional reference.
 * @return bool Whether the object is valid according to its annootations
 */
function validate (&$errors = NULL) {
  if (!class_exists("\\O\\Validator")) { include("Validator.php"); }
  $errors = Validator::validate($this->raw());
  return empty($errors);
}
#@+node:caminhante.20211024201823.1: *3* IteratorAggregate
#@+node:caminhante.20211024201813.1: *4* function getIterator
/** @return \ArrayIterator */
function getIterator (): \Traversable {
  $o = new \ArrayObject($this->o);
  return $o->getIterator();
}
#@+node:caminhante.20211024201918.1: *3* ArrayAccess
#@+node:caminhante.20211024201922.1: *4* function offsetExists
function offsetExists ($offset): bool {
  return isset($this->o[$offset]);
}
#@+node:caminhante.20211024201942.1: *4* function offsetGet
function offsetGet ($offset): mixed {
  return $this->o[$offset];
}
#@+node:caminhante.20211024201943.1: *4* function offsetSet
function offsetSet ($offset, $value): void {
  $this->o[$offset] = $value;
}
#@+node:caminhante.20211024201945.1: *4* function offsetUnset
function offsetUnset ($offset): void {
  unset($this->o[$offset]);
}
#@-others
}
#@+node:caminhante.20211024202304.1: ** function o
/**
 * @param mixed $p
 * @return \O\ObjectClass
 */
function o ($p) {
  if ($p instanceof ObjectClass) { return $p; }
  else { return new ObjectClass($p); }
}
#@+node:caminhante.20211024202355.1: ** function convertType
// supports types from phplint/phpdoc
// http://www.icosaedro.it/phplint/phpdoc.html#types
function convertType ($value, $type) {
  if (is_null($value)) { return $value; }
  $type = s($type)->parse_type();
  if ($type->isArray) {
    if (is_array($value)) {
      $newVal = array();
      foreach ($value as $key => $item) {
        if ($type->key !== NULL) {
          $newVal[convertType($key, $type->key)] = convertType($item, $type->value);
        } else {
          $newVal[] = convertType($item, $type->value);
        }
      }
      return $newVal;
    }
  } else {
    switch ($type->value) {
      case "void": return NULL;
      case "bool": case "boolean": return filter_var($value, FILTER_VALIDATE_BOOLEAN);
      case "FALSE": case "false": return FALSE;
      case "int": case "integer": return intval(is_object($value) ? (string) $value : $value);
      case "float": case "double": return floatval(is_object($value) ? (string) $value : $value);
      case "string": return strval($value);
      case "mixed": return $value;
      case "resource": return is_resource($value) ? $value : NULL;
      case "object": return is_object($value) ? $value : o($value)->cast();
      case "DateTime": return ($value instanceof DateTime) ? $value : new DateTime($value);
      default: return o($value)->cast($type->value);
    }
  }
  return NULL;
}
#@-others
#@-leo
