<?php namespace O;
#@+leo-ver=5-thin
#@+node:caminhante.20211024200632.5: * @file PDO.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20220725212523.1: ** class PDO
class PDO extends \PDO {
#@+others
#@+node:caminhante.20220725213153.1: *3* /vars
/**
 * @var bool Enable a fluent API (methods that return bool become chainable)
 */
private $fluent = TRUE;
/**
 * @var PDOProfiler The current query profiler
 */
private $profiler = NULL;
/**
 * @var string The string format to convert DateTime values to when binding params
 */
public static $dateFormat = "Y-m-d H:i:s";
#@+node:caminhante.20220725212615.1: *3* function __construct
public function __construct ($dsn, $username="", $password="", $options=array()) {
  $dsn = self::decorateDSN($dsn);
  parent::__construct($dsn, $username, $password, $options);
  if (isset($options["fluent"])) { $this->fluent = !!$options["fluent"]; }
  // not compatible with persistent PDO connections
  $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('O\\PDOStatement', array($this)));
  // don't sweep errors under the rug
  $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // don't emulate prepared statements
  $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}
#@+node:caminhante.20220725212632.1: *3* function decorateDSN
protected function decorateDSN ($dsn) {
  // default to utf8 if no charset if given
  if (strpos($dsn, "charset=") === FALSE) {
    if ((strpos($dsn, "mysql:") === 0) || (strpos($dsn, "pgsql:") === 0)) {
      // requires PHP >= 5.3.6
      $dsn = rtrim($dsn, "; ").";charset=utf8";
    } else if (strpos($dsn, "oci:") === 0) {
      $dsn = rtrim($dsn, "; ").";charset=AL32UTF8";
    };
  };
  return $dsn;
}
#@+node:caminhante.20220725212643.1: *3* function isFluent
/**
 * @return bool
 */
public function isFluent () {
  return $this->fluent;
}
#@+node:caminhante.20220725212659.1: *3* function setProfiler
/**
 * @param PDOProfiler $profiler
 */
public function setProfiler ($profiler) {
  $this->profiler = $profiler;
}
#@+node:caminhante.20220725212717.1: *3* function getProfiler
/**
 * @return PDOProfiler
 */
public function getProfiler () {
  return $this->profiler;
}
#@+node:caminhante.20220725212729.1: *3* function fetchAll
/**
 * Fetch all rows from the result set.
 * Additional parameters like PDOStatement::fetchAll
 * @param string $query
 * @param array $bind Parameters to bind (key/value)
 * @param int $fetchStyle
 * @return mixed
 */
public function fetchAll ($query, $bind = array(), $fetchStyle = NULL) {
  $args = array_slice(func_get_args(), 2);
  $args[0] = $fetchStyle ?: $this->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE);
  return $this->_internalFetch("fetchAll", $query, $bind, $args);
}
#@+node:caminhante.20220725212752.1: *3* function fetchRow
/**
 * Fetch the first row from the result set.
 * Additional parameters like PDOStatement::fetchRow
 * @param string $query
 * @param array $bind Parameters to bind (key/value)
 * @param int $fetchStyle
 * @return mixed
 */
public function fetchRow ($query, $bind = array(), $fetchStyle = NULL) {
  $args = array_slice(func_get_args(), 2);
  $args[0] = $fetchStyle ?: $this->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE);
  return $this->_internalFetch("fetch", $query, $bind, $args);
}
#@+node:caminhante.20220725212809.1: *3* function fetchColumn
/**
 * Fetch the first column from all rows
 * @param string $query
 * @param array $bind Parameters to bind (key/value)
 * @param int $columnNumber
 * @return array
 */
public function fetchColumn ($query, $bind = array(), $columnNumber = 0) {
  return $this->fetchAll($query, $bind, PDO::FETCH_COLUMN, $columnNumber);
}
#@+node:caminhante.20220725212823.1: *3* function fetchOne
/**
 * Fetch the first column of the first row.
 * @param string $query
 * @param array $bind Parameters to bind (key/value)
 * @param mixed $default Return this if the query has no results
 * @return mixed
 */
public function fetchOne ($query, $bind = array(), $default = NULL) {
  $value = $this->_internalFetch("fetchColumn", $query, $bind, array(0));
  return ($value === FALSE) ? $default : $value;
}
#@+node:caminhante.20220725212834.1: *3* function insert
/**
 * Insert a row into the DB
 * @param string $table
 * @param mixed $bind assoc array or object of key/value pairs
 * @param string $returning param for lastInsertId
 * @return string|int result of lastInsertId($returning)
 */
public function insert ($table, $bind = array(), $returning = NULL) {
  $bind = $this->_convertBind($bind, "insert");
  $values = array();
  for ($i = 0; $i < count($bind); $i++) $values[] = "?";
  $query =
    "insert into ".$table.PHP_EOL.
    "(".implode(", ", array_keys($bind)).")".PHP_EOL.
    "values".PHP_EOL.
    "(".implode(", ", $values).")";
  $stmt = $this->prepare($query);
  $stmt->bindParams(array_values($bind))->execute();
  $result = $this->lastInsertId($returning);
  $stmt->closeCursor();
  return $result;
}
#@+node:caminhante.20220725212847.1: *3* function update
/**
 * Update rows in $table
 * @param string $table
 * @param mixed $values assoc array or object of key/value pairs
 * @param string $where sql where clause (excluding "where" keyword)
 * @param mixed $whereBind assoc array or object of key/value pairs
 * @return int affected number of rows
 */
public function update ($table, $values, $where = "", $whereBind = NULL) {
  $query =
    "update ".$table.PHP_EOL .
    "set" . PHP_EOL;
  $values = $this->_convertBind($values);
  $bind = array();
  $set = array();
  foreach ($values as $field => $value) {
    // if we should use named parameters
    if ($this->_isAssoc($whereBind)) {
      $name = "pdo".count($set);
      $bind[$name] = $value;
      $set[] = "  ".$field." = :".$name;
    // used anonymous parameters
    } else {
      $set[] = "  ".$field." = ?";
      $bind[] = $value;
    }
  };
  $query .= implode(",".PHP_EOL, $set).PHP_EOL;
  if (!empty($where)) {
    $query .= "where".PHP_EOL.$where;
    if (!empty($whereBind)) {
      $whereBind = $this->_convertBind($whereBind);
      $bind = array_merge($bind, $whereBind);
    };
  };

  $stmt = $this->prepare($query);
  $stmt->bindParams($bind)->execute();
  $rowCount = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowCount;
}
#@+node:caminhante.20220725212908.1: *3* function delete
/**
 * Deletes rows from a table
 * @param string $table table to delete rows from
 * @param string $where sql where clause (excluding "where" keyword)
 * @param mixed $whereBind assoc array or object of key/value pairs
 * @return int affected number of rows
 */
public function delete ($table, $where = "", $whereBind = NULL) {
  $query = "delete from ".$table.PHP_EOL;
  $bind = array();
  if (!empty($where)) {
    $query .= "where".PHP_EOL.$where;
    if (!empty($whereBind)) {
      $bind = $this->_convertBind($whereBind, "delete");
    };
  };

  $stmt = $this->prepare($query);
  $stmt->bindParams($bind)->execute();
  $rowCount = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowCount;
}
#@+node:caminhante.20220725212918.1: *3* function exec
/**
 * @param string $statement
 * @return int
 */
public function exec ($statement): int|false {
  $id = $this->_beforeQuery($statement);
  $result = parent::exec($statement);
  $this->_afterQuery($id);
  return $result;
}
#@+node:caminhante.20220725212927.1: *3* function prepare
/**
 * @param string $statement
 * @param array $driver_options
 * @return PDOStatement
 */
public function prepare ($statement, $driver_options = array()): \PDOStatement|false {
  return parent::prepare($statement, $driver_options);
}
#@+node:caminhante.20220725212937.1: *3* function query
/**
 * @param string $statement
 * @return PDOStatement
 */
public function query (string $statement, ?int $fetchMode = null, mixed ...$fetchModeArgs): \PDOStatement|false {
  $id = $this->_beforeQuery($statement);
  $result = parent::query($statement, $fetchMode, $fetchModeArgs);
  $this->_afterQuery($id);
  return $result;
}
#@+node:caminhante.20220725212947.1: *3* function beginTransaction
/**
 * @return bool|PDO
 */
public function beginTransaction (): bool {
  $result = parent::beginTransaction();
  return $this->fluent ? $this : $result;
}
#@+node:caminhante.20220725212957.1: *3* function commit
/**
 * @return bool|PDO
 */
public function commit (): bool {
  $result = parent::commit();
  return $this->fluent ? $this : $result;
}
#@+node:caminhante.20220725213007.1: *3* function rollBack
/**
 * @return bool|PDO
 */
public function rollBack (): bool {
  $result = parent::rollBack();
  return $this->fluent ? $this : $result;
}
#@+node:caminhante.20220725213018.1: *3* function setAttribute
/**
 * @param int $attribute
 * @param mixed $value
 * @return bool|PDO
 */
public function setAttribute ($attribute, $value): bool|PDO {
  $result = parent::setAttribute($attribute, $value);
  return $this->fluent ? $this : $result;
}
#@+node:caminhante.20220725213026.1: *3* function _internalFetch
private function _internalFetch ($method, $query, $bind, $args) {
  /** @var \O\PDOStatement $stmt */
  $stmt = $this->prepare($query);
  $stmt->bindParams($bind);
  $stmt->execute();
  $result = call_user_func_array(array($stmt, $method), $args);
  $stmt->closeCursor();
  return $result;
}
#@+node:caminhante.20220725213037.1: *3* function _convertBind
/**
 * @param mixed $bind
 * @return array
 * @throws \PDOException
 */
private function _convertBind ($bind) {
  if (is_object($bind)) $bind = (array) $bind;
  if (!is_array($bind)) {
    throw new \PDOException(
      "O\\PDO::insert expects argument to be array or object", "90001");
  };
  return $bind;
}
#@+node:caminhante.20220725213048.1: *3* function _isAssoc
/**
 * @param mixed $bind
 * @return bool
 */
private function _isAssoc ($bind) {
  if (is_object($bind)) return true;
  if (is_array($bind)) {
    // true if array keys are not sequential and numeric
    return array_keys($bind) !== range(0, count($bind) - 1);
  }
  return false;
}
#@+node:caminhante.20220725213100.1: *3* function _beforeQuery
/**
 * @param $query
 * @param $params
 * @return int|null
 */
private function _beforeQuery ($query, $params = NULL) {
  if ($this->profiler) {
    return $this->profiler->queryStart($query, $params);
  } else {
    return NULL;
  }
}
#@+node:caminhante.20220725213112.1: *3* function _afterQuery
/**
 * @param int $id
 */
private function _afterQuery ($id) {
  if ($this->profiler) {
    $this->profiler->queryEnd($id);
  }
}
#@-others
}

#@+node:caminhante.20220725213121.1: ** class PDOStatement
class PDOStatement extends \PDOStatement {
#@+others
#@+node:caminhante.20220725213235.1: *3* /vars
/** @var PDO */
private $pdo = NULL;
/** @var array Parameters that are bound */
private $params = array();
#@+node:caminhante.20220725213337.1: *3* function __construct
/**
 * @param PDO $pdo
 * Return $this from API's that would return bool
 */
protected function __construct ($pdo) {
  $this->pdo = $pdo;
}
#@+node:caminhante.20220725213350.1: *3* function bindParams
/**
 * @param array|object $bind
 * @return PDOStatement|bool
 */
public function bindParams ($bind): bool|\PDOStatement {
  $success = TRUE;
  // support object with key value pairs (= named parameters)
  if (is_object($bind)) {
    // ChainableClass, StringClass, ArrayClass
    if (method_exists($bind, "raw")) $bind = $bind->raw();
    if (is_object($bind)) $bind = (array) $bind;
  };
  // support list of parameters (= anonymous parameters)
  if (!is_array($bind)) {
    $bind = func_get_args();
  };
  // support array of key value pairs (= named parameters)
  // and array of values (= anonymous parameters)
  if (is_array($bind)) {
    foreach ($bind as $key => &$value) {
      if ($this->_isAssocArray($bind)) { // named param
        if ($key[0] !== ":") $key = ":".$key;
      } else { // 1-indexed position for anon param
        $key++;
      };
      $success = $success && $this->bindParam($key, $value);
    };
  };
  return $this->pdo->isFluent() ? $this : $success;
}
#@+node:caminhante.20220725213403.1: *3* function bindColumn
/**
 * @param mixed $column
 * @param mixed $param
 * @param int $type
 * @param int $maxlen
 * @param mixed $driverdata
 * @return bool|PDOStatement
 */
public function bindColumn (
$column, &$param, $type = NULL, $maxlen = NULL, $driverdata = NULL
): bool {
  $result = parent::bindColumn($column, $param, $type, $maxlen, $driverdata);
  return $this->pdo->isFluent() ? $this : $result;
}
#@+node:caminhante.20220725213419.1: *3* function bindParam
/**
 * @param mixed $parameter
 * @param mixed $variable
 * @param int $data_type
 * @param int $length
 * @param mixed $driver_options
 * @return bool|PDOStatement
 */
public function bindParam (
$parameter, &$variable, $data_type = PDO::PARAM_STR, $length = 0, $driver_options = NULL
): bool {
  // ArrayClass, StringClass, ChainableClass
  if (is_object($variable) && method_exists($variable, "raw")) {
    $variable = $variable->raw();
  };
  if ($variable instanceof \DateTime) {
    $value = $variable->format(PDO::$dateFormat);
  } else {
    $value =& $variable;
  };
  $this->params[$parameter] = $value;
  $result = parent::bindParam($parameter, $value, $data_type, $length, $driver_options);
  return $this->pdo->isFluent() ? $this : $result;
}
#@+node:caminhante.20220725213434.1: *3* function bindValue
/**
 * @param mixed $parameter
 * @param mixed $value
 * @param int $data_type
 * @return bool|PDOStatement
 */
public function bindValue ($parameter, $value, $data_type = PDO::PARAM_STR): bool {
  if ($value instanceof \DateTime) {
    $value = $value->format(PDO::$dateFormat);
  };
  $this->params[$parameter] = $value;
  $result = parent::bindValue($parameter, $value, $data_type);
  return $this->pdo->isFluent() ? $this : $result;
}
#@+node:caminhante.20220725213442.1: *3* function closeCursor
/**
 * @return bool|PDOStatement
 */
public function closeCursor (): bool {
  $result = parent::closeCursor();
  return $this->pdo->isFluent() ? $this : $result;
}
#@+node:caminhante.20220725213454.1: *3* function execute
/**
 * @param array $input_parameters
 * @return bool|PDOStatement
 */
public function execute ($input_parameters = NULL): bool {
  if ($this->pdo->getProfiler()) {
    $id = $this->pdo->getProfiler()->queryStart(
      $this->queryString, $input_parameters ?: $this->params);
  }
  $result = parent::execute($input_parameters);
  if (isset($id)) $this->pdo->getProfiler()->queryEnd($id);
  return $this->pdo->isFluent() ? $this : $result;
}
#@+node:caminhante.20220725213508.1: *3* function nextRowSet
/**
 * @return bool|PDOStatement
 */
public function nextRowSet (): bool {
  $result = parent::nextRowSet();
  return $this->pdo->isFluent() ? $this : $result;
}
#@+node:caminhante.20220725213518.1: *3* function setAttribute
/**
 * @param int $attribute
 * @param mixed $value
 * @return bool|PDOStatement
 */
public function setAttribute ($attribute, $value): bool {
  $result = parent::setAttribute($attribute, $value);
  return $this->pdo->isFluent() ? $this : $result;
}
#@+node:caminhante.20220725213528.1: *3* function setFetchMode
/**
 * @param int $mode
 * @param array $params
 * @return bool|PDOStatement
 */
public function setFetchMode (int $mode, mixed ...$params): bool {
  $result = parent::setFetchMode($mode,$params);
  return $this->pdo->isFluent() ? $this : $result;
}
#@+node:caminhante.20220725213539.1: *3* function _isAssocArray
/**
 * Returns true if the array is associative (key/value pairs)
 * @param array $arr
 * @return bool
 */
private function _isAssocArray ($arr): bool {
  return array_keys($arr) !== range(0, count($arr) - 1);
}
#@-others
}
#@+node:caminhante.20220725213642.1: ** class PDOProfiler
class PDOProfiler {
#@+others
#@+node:caminhante.20220725213724.1: *3* /vars
/**
 * @var array [[duration, startTime, queryString, queryParams]]
 */
protected $profiles = array();
#@+node:caminhante.20220725213732.1: *3* function clear
public function clear () {
  $this->profiles = array();
}
#@+node:caminhante.20220725213742.1: *3* function queryStart
/**
 * Start profiling a query
 * @param string $text
 * @param mixed $bind
 * @return int The id of the query profile
 */
public function queryStart ($text, $bind) {
  $this->profiles[] = array(NULL, microtime(true), $text, $bind);
  return count($this->profiles) - 1;
}
#@+node:caminhante.20220725213752.1: *3* function queryEnd
/**
 * Finish a query being profiled
 * @param int $profileID
 */
public function queryEnd ($profileID) {
  if ($profileID === NULL) return;
  if (isset($this->profiles[$profileID])) {
    $arr =& $this->profiles[$profileID];
    $arr[0] = microtime(true) - $arr[1];
  }
}
#@+node:caminhante.20220725213801.1: *3* function getProfiles
/**
 * Return the query profile data
 * @return array
 */
public function getProfiles () {
  return $this->profiles;
}
#@-others
}
#@-others
#@-leo
