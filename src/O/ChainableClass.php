<?php namespace O;
#@+leo-ver=5-thin
#@+node:caminhante.20211024200632.9: * @file ChainableClass.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20220725211143.1: ** /includes
// s()
if (!class_exists("\\O\\StringClass")) { include("StringClass.php"); }
// a()
if (!class_exists("\\O\\ArrayClass")) { include("ArrayClass.php"); }
// o()
if (!class_exists("\\O\\ObjectClass")) { include("ObjectClass.php"); }
#@+node:caminhante.20220725211210.1: ** class ChainableClass
/**
 * Supporting class for c() function
 */
class ChainableClass implements \IteratorAggregate, \ArrayAccess {
private $o;
#@+others
#@+node:caminhante.20220725211243.1: *3* function __construct
function __construct ($o) {
  $this->o = $o;
}
#@+node:caminhante.20220725211517.1: *3* function __toString
function __toString () {
  return (string) $this->o;
}
#@+node:caminhante.20220725211524.1: *3* static function asChainable
private static function asChainable ($p): ChainableClass {
  switch (gettype($p)) {
    case "string":
      return cs($p);
    case "array":
      return ca($p);
    case "object":
      return co($p);
    default:
      if (is_object($p)) {
        return c($p);
      } else {
        return $p;
      }
  }
}
#@+node:caminhante.20220725211706.1: *3* function __call
/**
 * @param string $fn
 * @param array $args
 * @return mixed|\O\ChainableClass
 */
function __call ($fn, $args): ChainableClass {
  return self::asChainable(call_user_func_array(array($this->o, $fn), $args));
}
#@+node:caminhante.20220725211712.1: *3* function raw
function raw (): mixed {
  if (is_object($this->o) && method_exists($this->o, "raw")) {
    return call_user_func(array($this->o, "raw"));
  } else {
    return $this->o;
  }
}
#@+node:caminhante.20220725211741.1: *3* Implements \IteratorAggregate
#@+node:caminhante.20220725211746.1: *4* getIterator
/**
 * @return \Traversable
 */
function getIterator (): \Traversable {
  if (method_exists($this->o, "getIterator")) {
    return call_user_func(array($this->o, "getIterator"));
  } else {
    return NULL;
  }
}
#@+node:caminhante.20220725211815.1: *3* Implements \ArrayAccess
#@+node:caminhante.20220725211837.1: *4* offsetExists
function offsetExists ($offset): bool {
  return isset($this->o[$offset]);
}
#@+node:caminhante.20220725211843.1: *4* offsetGet
function offsetGet ($offset): ChainableClass {
  return self::asChainable($this->o[$offset]);
}
#@+node:caminhante.20220725211847.1: *4* offsetSet
function offsetSet ($offset, $value): void {
  $this->o[$offset] = $value;
}
#@+node:caminhante.20220725211854.1: *4* offsetUnset
function offsetUnset ($offset): void {
  unset($this->o[$offset]);
}
#@-others
}
#@+node:caminhante.20220725211214.1: ** c

/**
 * @param mixed $o
 * @return \O\ChainableClass
 */
function c ($o) {
  if ($o instanceof ChainableClass) {
    return $o;
  } else {
    return new ChainableClass($o);
  }
}
#@+node:caminhante.20220725211218.1: ** cs

/**
 * @param string $o
 * @return \O\ChainableClass|\O\StringClass
 */
function cs ($o) {
  return c(s($o));
}
#@+node:caminhante.20220725211222.1: ** ca

/**
 * @param array $o
 * @return \O\ChainableClass|\O\ArrayClass
 */
function ca ($o) {
  return c(a($o));
}
#@+node:caminhante.20220725211224.1: ** co

/**
 * @param mixed $o
 * @return \O\ChainableClass|\O\ObjectClass
 */
function co ($o) {
  return c(o($o));
}
#@-others
#@-leo
