<?php namespace O;
#@+leo-ver=5-thin
#@+node:caminhante.20211024200632.10: * @file ArrayClass.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20220725205255.1: ** class ArrayClass
/**
 * Supporting class for the a() function
 */
class ArrayClass implements \IteratorAggregate, \ArrayAccess, \Countable {
private array $a;
#@+others
#@+node:caminhante.20231104205315.1: *3* static function unwrap
public static function unwrap (array $arrayOfArrays) {
  return a( $arrayOfArrays )
    ->map(function ($x) {
      if (is_a($x, "O\ArrayClass")) {$x = $x->raw();}
      if (is_array($x)) { $x = ArrayClass::unwrap($x); }
      return $x;
    })->raw();
}
#@+node:caminhante.20220725205513.1: *3* function __construct
function __construct (&$a = array()) {
  if (is_a($a,'ArrayClass')) { $this->a = $a->raw(); }
  else { $this->a =& $a; }
}
#@+node:caminhante.20240327150132.1: *3* function __toString
function __toString () {
  return ObjectClass::json_print($this->a);
}
#@+node:caminhante.20220725205557.1: *3* function count
/**
 * Count all elements in an array
 * @param int $mode If set to COUNT_RECURSIVE, will recursively count the array.
 * @return int
 */
function count ($mode = COUNT_NORMAL): int {
  return count($this->a, $mode);
}
#@+node:caminhante.20220725205611.1: *3* function has
/**
 * Checks if a value exists in an array
 * @param mixed $needle The searched value
 * @param bool $strict If true will also compare the types
 * @return bool
 */
function has ($needle, $strict = FALSE) {
  return in_array($needle, $this->a, $strict);
}
#@+node:caminhante.20220725205617.1: *3* function search
/**
 * Searches the array for a given value and returns the corresponding key if successful
 * @param mixed $needle The searched value
 * @param bool $strict If true will also compare the types
 * @return mixed
 */
function search ($needle, $strict = FALSE) {
  return array_search($needle, $this->a, $strict);
}
#@+node:caminhante.20220725205625.1: *3* function shift
/**
 * Shift an element off the beginning of array
 * @return mixed
 */
function shift () {
  return array_shift($this->a);
}
#@+node:caminhante.20220725205629.1: *3* function unshift
/**
 * Prepend one or more elements to the beginning of an array
 * @param mixed $value1 First value to prepend
 * @return int
 */
function unshift ($value1) {
  $args = func_get_args();
  for ($i = count($args) - 1; $i >= 0; $i--) {
    array_unshift($this->a, $args[$i]);
  };
  return count($this->a);
}
#@+node:caminhante.20220725205637.1: *3* function key_exists
/**
 * Checks if the given key or index exists in the array
 * @param mixed $key Value to check
 * @return bool
 */
function key_exists ($key) {
  return array_key_exists($key, $this->a);
}
#@+node:caminhante.20220725205647.1: *3* function implode
/**
 * Join array elements with a string
 * @param string $glue Defaults to an empty string
 * @return string|StringClass
 */
function implode ($glue = "") {
  return s(implode($glue, $this->a));
}
#@+node:caminhante.20220725205701.1: *3* function keys
/**
 * Return all the keys of an array.
 * Due to limitations the additional parameters of array_keys are not supported.
 * @return Array|ArrayClass
 */
function keys () {
  return a(array_keys($this->a));
}
#@+node:caminhante.20220725205706.1: *3* function values
/**
 * Return all the values of an array
 * @return Array|ArrayClass
 */
function values () {
  return a(array_values($this->a));
}
#@+node:caminhante.20220725205711.1: *3* function pop
/**
 * Pop the element off the end of array
 * @return mixed
 */
function pop () {
  return array_pop($this->a);
}
#@+node:caminhante.20220725205716.1: *3* function push
/**
 * Push one or more elements onto the end of array
 * @param mixed $value1 The first value to append
 * @return int
 */
function push ($value1) {
  $args = func_get_args();
  for ($i = 0; $i < count($args); $i++) {
    array_push($this->a, $args[$i]);
  };
  return count($this->a);
}
#@+node:caminhante.20220725205720.1: *3* function slice
/**
 * Extract a slice of the array
 * @param int $offset Start from this offset in the array. If negative, offset from end.
 * @param int $length Number of elements to slice. If negative, stop slicing $length from the end.
 * @param bool $preserve_keys Preserve the array's keys
 * @return Array|ArrayClass
 */
function slice ($offset, $length = NULL, $preserve_keys = false) {
  $r = array_slice($this->a, $offset, $length, $preserve_keys);
  return a($r);
}
#@+node:caminhante.20220725205726.1: *3* function splice
/**
 * Remove a portion of the array and replace it with something else
 * @param int $offset Start from this offset in the array. If negative, offset from end.
 * @param int $length Number of elements to slice. If negative, stop splicing $length from the end.
 * @param Array $replacement Array to insert instead of the spliced segment.
 * @return Array|ArrayClass
 */
function splice ($offset, $length = 0, $replacement = NULL) {
  if ($replacement == NULL) $replacement = array();
  return a(array_splice($this->a, $offset, $length, $replacement));
}
#@+node:caminhante.20220725205730.1: *3* function merge
/**
 * Merge one or more arrays
 * @param Array $array1 The first array to merge
 * @return ArrayClass
 */
function merge ($array1) {
  $args = call_user_func_array("array_merge", ArrayClass::unwrap(func_get_args()) );
  $r = array_merge($this->a, $args);
  return a($r);
}
#@+node:caminhante.20231104203124.1: *3* function concat
/**
 * Append array elements from the second array to this while not overwriting the elements
 * @param array $array1
 * @return ArrayClass
 */
function concat (array $array1): ArrayClass {
  return a(array($array1) + array($this->a));
}
#@+node:caminhante.20220725205735.1: *3* function map
/**
 * Applies the callback to the elements of this array and additional ones
 * @param Callable $callback Callback function to run for each element in each array.
 * The number of parameters that the callback function accepts should match the number of arrays passed
 * @param Array $array2 The second array whose items to pass as the second argument of $callback.
 * @return Array|ArrayClass
 */
function map ($callback, $array2 = NULL) {
  $args = func_get_args();
  $params = a($args)->slice(1);
  a($params)->unshift($callback, $this->a);
  $r = call_user_func_array("array_map", $params->raw());
  return a($r);
}
#@+node:caminhante.20220725210154.1: *3* function reduce
/**
 * Iteratively reduce the array to a single value using a callback function
 * @param Callable $callback The callback function to call
 *    <code>mixed function($carry, $item)</code>
 *    $carry is the previous iteration's return value, for the first iteration it holds $initial<br>
 *    $item holds the value of the current iteration
 * @param mixed $initial The initial value for the first iteration
 * @return mixed
 */
function reduce ($callback, $initial = NULL) {
  return array_reduce($this->a, $callback, $initial);
}
#@+node:caminhante.20220725210158.1: *3* function filter
/**
 * Filters elements of an array using a callback function
 * @param Callable $callback If this returns true for a value, the value is in the result array.
 * @return Array|ArrayClass
 */
function filter ($callback = NULL) {
  return a(array_filter($this->a, $callback));
}
#@+node:caminhante.20220725210202.1: *3* function sum
/**
 * Calculate the sum of values in an array
 * @return number
 */
function sum () {
  return array_sum($this->a);
}
#@+node:caminhante.20220725210217.1: *3* function begin
/**
 * Set the internal pointer of an array to its first element
 * @return mixed The first array value
 */
function begin () {
  return reset($this->a);
}
#@+node:caminhante.20220725210224.1: *3* function current
/**
 * Return the current element in an array
 * @return mixed
 */
function current () {
  return current($this->a);
}
#@+node:caminhante.20220725210230.1: *3* function next
/**
 * Advance the internal array pointer of an array
 * @return mixed The next array value
 */
function next () {
  return next($this->a);
}
#@+node:caminhante.20220725210401.1: *3* function end
/**
 * Set the internal pointer of an array to its last element
 * @return mixed The last array value
 */
function end () {
  return end($this->a);
}
#@+node:caminhante.20220725210404.1: *3* function each
/**
 * Return the current key and value pair from an array and advance the array cursor
 * @return Array|ArrayClass
 */
function each () {
  return a(each($this->a));
}
#@+node:caminhante.20220725210602.1: *3* function clear
/**
 * Remove all elements from the array
 * @return Array|ArrayClass
 */
function clear () {
  return $this->a = array();
}
#@+node:caminhante.20220725210606.1: *3* function raw
/**
 * Return the internal raw Array for this ArrayClass object
 * @return Array
 */
function raw () {
  return $this->a;
}
#@+node:caminhante.20220725210609.1: *3* implements \IteratorAggregate
#@+node:caminhante.20220725210613.1: *4* function getIterator
function getIterator (): \Traversable {
  $o = new \ArrayObject($this->a);
  return $o->getIterator();
}
#@+node:caminhante.20220725210648.1: *3* Implements \ArrayAccess
#@+node:caminhante.20220725210708.1: *4* function offsetExists
function offsetExists ($offset): bool {
  return isset($this->a[$offset]);
}
#@+node:caminhante.20220725210712.1: *4* function offsetGet
function offsetGet ($offset): mixed {
  return $this->a[$offset];
}
#@+node:caminhante.20220725210716.1: *4* function offsetSet
function offsetSet ($offset, $value): void {
  $this->a[$offset] = $value;
}
#@+node:caminhante.20220725210720.1: *4* function offsetUnset
function offsetUnset ($offset): void {
  unset($this->a[$offset]);
}
#@-others
}
#@+node:caminhante.20220725205443.1: ** function a
/**
 * @param string $p
 * @return \O\ArrayClass
 */
function a (&$p) {
  if ($p instanceof ArrayClass) {
    return $p;
  } else {
    return new ArrayClass($p);
  }
}
#@-others
#@-leo
