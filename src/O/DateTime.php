<?php
//@+leo-ver=5-thin
//@+node:caminhante.20211024200632.8: * @file DateTime.php
//@@first
namespace O;
//@+others
//@+node:caminhante.20220725212117.1: ** class DateTime
class DateTime extends \DateTime implements \JsonSerializable {
//@+others
//@+node:caminhante.20220725212243.1: *3* ISO8601
/**
 * An ISO8601 format string for PHP's date functions that's compatible with JavaScript's Date's constructor method
 * Example: 2013-04-12T16:40:00-04:00
 *
 * \DateTime::ISO8601 does not add the colon to the timezone offset which is required for iPhone
 */
const ISO8601 = 'Y-m-d\TH:i:sP';
//@+node:caminhante.20220725212246.1: *3* function __toString
/**
 * Return date in ISO8601 format
 *
 * @return String
 */
public function __toString () {
  return $this->format(static::ISO8601);
}
//@+node:caminhante.20220725212250.1: *3* function jsonSerialize
/**
 * Return date in ISO8601 format
 *
 * @return string
 */
public function jsonSerialize () {
  return (string) $this;
}
//@-others
}
//@-others
//@-leo
