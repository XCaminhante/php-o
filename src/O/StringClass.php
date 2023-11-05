<?php namespace O;
#@+leo-ver=5-thin
#@+node:caminhante.20211024200632.2: * @file StringClass.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20221112200714.1: ** /setup code
// verify that output and string handling occurs as UTF-8
if (!extension_loaded("mbstring")) {
  throw new \Exception("enable the mbstring extension in php.ini");
} else if (headers_sent()) {
  throw new \Exception("headers already sent, load O.php at the top of the page");
} else {
  ini_set("default_charset", "UTF-8");
  mb_internal_encoding("UTF-8");
  mb_regex_encoding("UTF-8");
};
#@+node:caminhante.20221112200814.1: ** class StringClass
/**
 * Supporting class for the s() function
 */
class StringClass implements \IteratorAggregate, \ArrayAccess {
private $s;
#@+others
#@+node:caminhante.20221112200956.1: *3* function __construct
function __construct ($s = "") {
  if (is_null($s)) {$s = "";}
  $this->s = $s;
}
#@+node:caminhante.20221112201012.1: *3* function __toString
function __toString () {
  return strval($this->s);
}
#@+node:caminhante.20221112201016.1: *3* PHP style API
#@+node:caminhante.20221112201032.1: *4* function pos
/**
 * Find the position of the first occurrence of a substring in a string
 * @param string $needle The string to search
 * @param int $offset The position to start searching
 * @return int
 */
function pos ($needle, $offset = 0): int {
  return mb_strpos($this->s, $needle, $offset);
}
#@+node:caminhante.20221112201037.1: *4* function ipos
/**
 * Find the position of the first occurrence of a case-insensitive substring in a string
 * @param string $needle The string to search
 * @param int $offset The position to start searching
 * @return int
 */
function ipos ($needle, $offset = 0): int {
  return mb_stripos($this->s, $needle, $offset);
}
#@+node:caminhante.20221112201044.1: *4* function rpos
/**
 * Find the position of the last occurrence of a substring in a string
 * @param string $needle The string to search
 * @param int $offset The position to start searching
 * @return int
 */
function rpos ($needle, $offset = 0): int {
  return mb_strrpos($this->s, $needle, $offset);
}
#@+node:caminhante.20221112201048.1: *4* function ripos
/**
 * Find the position of the last occurrence of a case-insensitive substring in a string
 * @param string $needle The string to search
 * @param int $offset The position to start searching
 * @return int
 */
function ripos ($needle, $offset = 0): int {
  return mb_strripos($this->s, $needle, $offset);
}
#@+node:caminhante.20221112201052.1: *4* function explode
/**
 * Split a string by string
 * @param string $delimiter The boundary string
 * @param int $limit If limit is set and positive, the returned array will contain
 * a maximum of limit elements with the last element containing the rest of string.
 * @return array|ArrayClass
 */
function explode ($delimiter, $limit = 0xFFFFFF): ArrayClass {
  // split in utf-8 characters
  if ($delimiter == "") {
    $l = min($this->len(), $limit);
    $r = array();
    for ($i = 0; $i < $l; $i++) {
      $r[] = $this->substr($i, 1);
    };
    return a($r);
  } else {
    $e = explode($delimiter, $this->s, $limit);
    return a($e);
  }
}
#@+node:caminhante.20221112201058.1: *4* function trim
/**
 * Strip whitespace (or other characters) from the beginning and end of a string
 * @param string $charlist Characters to strip
 * @return string|StringClass
 */
function trim ($charlist = " \t\n\r\0\x0B"): StringClass {
  return s(trim($this->s, $charlist));
}
#@+node:caminhante.20221112201101.1: *4* function ltrim
/**
 * Strip whitespace (or other characters) from the beginning of a string
 * @param string $charlist Characters to strip
 * @return string|StringClass
 */
function ltrim ($charlist = " \t\n\r\0\x0B"): StringClass {
  return s(ltrim($this->s, $charlist));
}
#@+node:caminhante.20221112201105.1: *4* function rtrim
/**
 * Strip whitespace (or other characters) from the end of a string
 * @param string $charlist Characters to strip
 * @return string|StringClass
 */
function rtrim ($charlist = " \t\n\r\0\x0B"): StringClass {
  return s(rtrim($this->s, $charlist));
}
#@+node:caminhante.20221112201110.1: *4* function pad
/**
 * Pad a string to a certain length with another string
 * @param int $padLength Length in characters to pad to
 * @param string $padString String to pad with
 * @param int $padType STR_PAD_LEFT, STR_PAD_RIGHT (default) or STR_PAD_BOTH
 * @return string|StringClass
 */
function pad ($padLength, $padString = " ", $padType = STR_PAD_RIGHT): StringClass {
  // padLength == byte length, so calculate it correctly
  $padLength += (strlen($this->s) - $this->len());
  $padStringByteToCharRatio = strlen($padString) / mb_strlen($padString);
  if ($padStringByteToCharRatio > 1) {
    $charsToAdd = ($padLength - strlen($this->s));
    $padLength -= $charsToAdd;
    $padLength += ceil($charsToAdd * $padStringByteToCharRatio);
  };
  return s(str_pad($this->s, $padLength, $padString, $padType));
}
#@+node:caminhante.20221112201113.1: *4* function len
/**
 * Get the string length in characters
 * @return int
 */
function len (): int {
  return mb_strlen($this->s);
}
#@+node:caminhante.20221112201116.1: *4* function tolower
/**
 * Make a string lowercase
 * @return string|StringClass
 */
function tolower (): StringClass {
  return s(mb_strtolower($this->s));
}
#@+node:caminhante.20221112201256.1: *4* function toupper
/**
 * Make a string uppercase
 * @return string|StringClass
 */
function toupper (): StringClass {
  return s(mb_strtoupper($this->s));
}
#@+node:caminhante.20221112201259.1: *4* function substr
/**
 * Return part of a string
 * @param int $start If negative, counts from the end of the string
 * @param int $length
 * @return string|StringClass
 */
function substr ($start = 0, $length = 0xFFFFFFF): StringClass {
  return s(mb_substr($this->s, $start, $length));
}
#@+node:caminhante.20221112201304.1: *4* function replace
/**
 * Replace all occurrences of the search string with the replacement string
 * @param string $search The value being searched for
 * @param string $replace The replacement value
 * @param int $count If set, the number of replacements performed
 * @return string|StringClass
 */
function replace ($search, $replace, &$count = NULL): StringClass {
  return s(str_replace($search, $replace, $this->s, $count));
}
#@+node:caminhante.20221112201310.1: *4* function ireplace
/**
 * Replace all occurrences of the search string (case-insensitive) with the replacement string
 * @param string $search The value being searched for
 * @param string $replace The replacement value
 * @param int $count If set, the number of replacements performed
 * @return string|StringClass
 */
function ireplace ($search, $replace, &$count = NULL): StringClass {
  return s(str_ireplace($search, $replace, $this->s, $count));
}
#@+node:caminhante.20221112201315.1: *4* function preg_match
/**
 * Perform a regular expression match
 * @param string $pattern The pattern to search for
 * @param array $matches If provided it is filled with the results of the search
 * $matches[0] will contain the text that matched the full pattern,
 * $matches[1] will have the text that matched the first captured parenthesized subpattern, and so on.
 * @param int $flags If PREG_OFFSET_CAPTURE for every occurring match the appendant string offset will also be returned.
 * Note that this changes the value of matches into an array where every element is an array consisting of the matched string at offset 0 and its string offset into subject at offset 1.
 * @param int $offset Alternate start of the search (in characters)
 * @return int
 */
function preg_match ($pattern, &$matches = NULL, $flags = 0, $offset = 0): int {
  if (!is_array($matches)) { $matches = array(); }
  // convert offset from characters to bytes
  if ($offset) { $offset = strlen($this->substr(0, $offset)); }
  $result = preg_match($pattern, $this->s, $matches, $flags, $offset);
  if ($flags & PREG_OFFSET_CAPTURE) {
    foreach ($matches as &$match) {
      // convert offset in bytes into offset in code points
      $match[1] = mb_strlen(substr($this->s, 0, $match[1]));
    }
  };
  return $result;
}
#@+node:caminhante.20221112201321.1: *4* function preg_match_all
/**
 * Searches subject for all matches to the regular expression given in pattern and puts them in matches in the order specified by flags.
 * @param string $pattern The pattern to search for
 * @param array $matches If provided it is filled with the results of the search
 * @param int $flags {@see http://php.net/manual/en/function.preg-match-all.php}
 * @param int $offset Alternate start of the search (in characters)
 * @return int
 */
function preg_match_all ($pattern, &$matches = NULL, $flags = PREG_PATTERN_ORDER, $offset = 0): int {
  if (!is_array($matches)) { $matches = array(); }
  // convert offset from characters to bytes
  if ($offset) { $offset = strlen($this->substr(0, $offset)); }
  $result = preg_match_all($pattern, $this->s, $matches, $flags, $offset);
  if ($flags & PREG_OFFSET_CAPTURE) {
    foreach ($matches as &$group) {
      foreach ($group as &$match) {
        // convert offset in bytes into offset in code points
        $match[1] = mb_strlen(substr($this->s, 0, $match[1]));
      };
    };
  };
  return $result;
}
#@+node:caminhante.20221112201328.1: *4* function preg_replace
/**
 * Perform a regular expression search and replace
 * @param string|array $pattern The pattern(s) to search for
 * @param string|array $replacement The string(s) to replace with
 * Each element from $pattern is replaced with its counterpart from $replacement
 * @param int $limit The maximal number of replacements
 * @param int $count If specified it is filled with the number of replacements done
 * @return string|StringClass
 */
function preg_replace ($pattern , $replacement , $limit = -1, &$count = NULL): StringClass {
  return s(preg_replace($pattern, $replacement, $this->s, $limit, $count));
}
#@+node:caminhante.20221112201332.1: *4* function in_array
/**
 * Checks if a value exists in an array
 * @param array|ArrayClass $haystack
 * @return bool
 */
function in_array ($haystack): bool {
  if (!is_array($haystack) && ($haystack instanceof ArrayClass)) {
    $haystack = $haystack->raw();
  }
  return in_array($this->s, $haystack);
}
#@+node:caminhante.20221112201552.1: *3* JavaScript-style API
#@+node:caminhante.20221112201600.1: *4* function charAt
/**
 * Returns the specified character from a string.
 * @param int $index
 * @return string|StringClass
 */
function charAt ($index): StringClass {
  return s($this->substr($index, 1));
}
#@+node:caminhante.20221112201608.1: *4* function indexOf
/**
 * Returns the index of the first occurrence of the specified value,
 * starting the search at fromIndex. Returns -1 if the value is not found.
 * @param string $search
 * @param int $start
 * @return int
 */
function indexOf ($search, $start = 0): int {
  $pos = s($this->substr($start))->pos($search);
  return ($pos === FALSE) ? -1 : $pos+$start;
}
#@+node:caminhante.20221112201614.1: *4* function lastIndexOf
/**
 * Returns the index of the last occurrence of the specified value,
 * starting the search at fromIndex. Returns -1 if the value is not found.
 * @param string $search
 * @param int $start
 * @return int
 */
function lastIndexOf ($search, $start = 0): int {
  $pos = s($this->substr(0, $start))->rpos($search);
  return ($pos === FALSE) ? -1 : $pos;
}
#@+node:caminhante.20221112201618.1: *4* function match
/**
 * Retrieves the matches when matching a string against a regular expression.
 * @param string $regexp
 * @return array|ArrayClass|null
 */
function match ($regexp): ArrayClass|null {
  $matches = array();
  if ($this->preg_match($regexp, $matches)) {
    return a($matches);
  };
  return NULL;
}
#@+node:caminhante.20231104194423.1: *4* function repeat
/**
 * Repeats a string.
 * @param int $times
 * @return string|null
 */
function repeat (int $times): StringClass|null {
  if ($times <= 0) { return s(""); }
  $r = $this->s;
  while ($times > 1) {
    if ($times % 2 == 0) { $r .= $r; $times >>= 2; }
    else { $r .= $this->s; $times -= 1; }
  }
  return s($r);
}
#@+node:caminhante.20221112201700.1: *4* function replace
// replace() already implemented for PHP syntax
#@+node:caminhante.20221112201709.1: *4* function split
/**
 * Splits the string into an array of strings
 * @param string $separator
 * @param int $limit
 * @return array|ArrayClass
 */
function split ($separator = NULL, $limit = 0xFFFFFF) {
  if ($separator === NULL) return array($this->s);
  return $this->explode($separator, $limit);
}
#@+node:caminhante.20221112201718.1: *4* function substr
// substr() already implemented for PHP syntax
#@+node:caminhante.20221112201722.1: *4* function substring
/**
 * Returns a subset of a string between one index and another,
 * or through the end of the string.
 * @param int $start
 * @param int $end
 * @return string|StringClass
 */
function substring ($start, $end = NULL) {
  return $this->substr($start, ($end !== NULL) ? $end-$start : 0xFFFFFFF);
}
#@+node:caminhante.20221112201727.1: *4* function toLowerCase
/**
 * Convert to lowercase
 * @return string|StringClass
 */
function toLowerCase () {
  return $this->tolower();
}
#@+node:caminhante.20221112201730.1: *4* function toUpperCase
/**
 * Convert to uppercase
 * @return string|StringClass
 */
function toUpperCase () {
  return $this->toupper();
}
#@+node:caminhante.20221112201736.1: *4* function trim
// trim() already implemented for PHP syntax
#@+node:caminhante.20221112201739.1: *4* function trimLeft
/**
 * Removes whitespace from the left end of a string
 * @return string|StringClass
 */
function trimLeft () {
  return $this->ltrim();
}
#@+node:caminhante.20221112201742.1: *4* function trimRight
/**
 * Removes whitespace from the right end of a string
 * @return string|StringClass
 */
function trimRight () {
  return $this->rtrim();
}
#@+node:caminhante.20221112201746.1: *4* function valueOf
/**
 * Return the internal raw string value
 * @return string|StringClass
 */
function valueOf () {
  return $this->s;
}
#@+node:caminhante.20221112201907.1: *3* encoder functions
#@+node:caminhante.20221112201917.1: *4* function html
/**
 * Securely encode the string for the html element context
 * {@see https://www.owasp.org/index.php/Abridged_XSS_Prevention_Cheat_Sheet}
 * @return string|StringClass
 */
function html () {
  $s = htmlspecialchars($this->s, ENT_QUOTES, "UTF-8");
  $s = s($s)->replace("/", "&#x2F;");
  $s = s($s)->replace("&apos;", "&#039;");
  return $s;
}
#@+node:caminhante.20221112201921.1: *4* function script
/**
 * Securely encode the string for the script element context
 * {@see https://www.owasp.org/index.php/Abridged_XSS_Prevention_Cheat_Sheet}
 * @return string|StringClass
 */
function script () {
  return json_encode($this->s, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
}
#@+node:caminhante.20221112201925.1: *4* function json
/**
 * Securely encode the string for the JSON context
 * {@see https://www.owasp.org/index.php/Abridged_XSS_Prevention_Cheat_Sheet}
 * @return string|StringClass
 */
function json () {
  return $this->script();
}
#@+node:caminhante.20221112201957.1: *3* IteratorAggregate
#@+node:caminhante.20221112202004.1: *4* function getIterator
/**
 * @return \ArrayIterator|\Traversable
 */
function getIterator (): \Traversable {
  $o = new \ArrayObject($this->explode(""));
  return $o->getIterator();
}
#@+node:caminhante.20221112202212.1: *3* ArrayAccess
#@+node:caminhante.20221112202218.1: *4* function offsetExists
function offsetExists ($offset): bool {
  return $offset < $this->len();
}
#@+node:caminhante.20221112202220.1: *4* function offsetGet
function offsetGet ($offset): StringClass {
  return s($this->substr($offset, 1));
}
#@+node:caminhante.20221112202223.1: *4* function offsetSet
function offsetSet ($offset, $value): void {
  $char = s($value)->substr(0, 1);
  $this->s = $this->substr(0, $offset) . $char . $this->substr($offset + 1);
}
#@+node:caminhante.20221112202225.1: *4* function offsetUnset
function offsetUnset ($offset): void {
  $this->s = $this->substr(0, $offset);
}
#@+node:caminhante.20221112202248.1: *3* other methods
#@+node:caminhante.20221112202256.1: *4* function parse_type
/**
 * parse type string (phplint / phpdoc syntax)
 * {@see http://www.icosaedro.it/phplint/phpdoc.html#types}
 * @return \O\VariableType
 */
function parse_type (): \O\VariableType {
  $type = $this->s;
  $matches = array();
  $isArray = FALSE;
  $keyType = NULL;
  // array[keytype]type
  if (s($type)->preg_match("/array(?:\\[([\S]*)\\]([\S]*))?/", $matches)) {
    $isArray = TRUE;
    $keyType = $matches[1];
    $type = $matches[2];
    // type[]
  } else if (s($type)->preg_match("/([^\\[]+)\\[\\]/", $matches)) {
    $isArray = TRUE;
    $keyType = NULL;
    $type = $matches[1];
  } else if ($type == "array") {
    $isArray = TRUE;
    $keyType = NULL;
    $type = "mixed";
  };
  $validTypes = array(
    "void",
    "bool", "boolean",
    "int", "integer", "float", "double",
    "string", "resource", "object", "mixed");
  if (!s($keyType)->in_array($validTypes)) {
    if (empty($keyType) || !class_exists($keyType)) {
      $keyType = NULL;
    };
  };
  if (!s($type)->in_array($validTypes)) {
    if (empty($type) || !class_exists($type)) {
      $type = "mixed";
    };
  };
  return new VariableType($isArray, $keyType, $type);
}
#@+node:caminhante.20221112202301.1: *4* function clear
/**
 * Set this string object to the empty string
 * @return string|StringClass
 */
function clear (): StringClass {
  $this->s = "";
  return $this;
}
#@+node:caminhante.20221112202304.1: *4* function raw
/**
 * Return the internal primitive string value
 * @return string
 */
function raw (): string {
  return $this->s;
}
#@-others
}
#@+node:caminhante.20221112200825.1: ** class VariableType
class VariableType {
/** @var bool */
public $isArray = FALSE;
/** @var string */
public $key = "void";
/** @var string */
public $value = "void";
public function __construct ($isArray = FALSE, $key = "void", $value = "void") {
  $this->isArray = $isArray;
  $this->key = $key;
  $this->value = $value;
}
}
#@+node:caminhante.20221112200845.1: ** function s
/**
 * @param $p string
 * @return \O\StringClass
 */
function s ($p): StringClass {
  if ($p instanceof StringClass) {
    return $p;
  } else {
    return new StringClass($p);
  }
}
#@-others
#@-leo
