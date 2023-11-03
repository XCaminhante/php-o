<?php
#@+leo-ver=5-thin
#@+node:caminhante.20230706212234.5: * @file OPDOMySQLTest.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20230724205559.1: ** /include
include_once realpath(__DIR__)."/../O.php";
#@+node:caminhante.20230724205614.1: ** class OPDOMySQLTest
class OPDOMySQLTest extends PHPUnit_Framework_TestCase {
#@+others
#@+node:caminhante.20230724205641.1: *3* /vars
/** @var \O\PDO */
static protected $db = NULL;
/** @var string */
static protected $dbError = NULL;
#@+node:caminhante.20230724205654.1: *3* setUp
protected function setUp() {
  // mysql connection parameters
  $dsn = 'mysql:host=localhost;dbname=test';
  $username = 'root';
  $password = '';

  if (!extension_loaded('pdo_mysql')) {
    $this->markTestSkipped(
      'The PDO mysql extension is not available.'
    );
  }
  if (self::$dbError === NULL) {
    try {
      self::$db = new O\PDO($dsn, $username, $password);
    } catch (Exception $e) {
      self::$dbError = $e->getMessage();
    };
  };
  if (self::$dbError !== NULL) {
    $this->markTestSkipped("Unable to connect to mysql: ".self::$dbError);
  };
  self::$db->exec("DROP TABLE IF EXISTS test");
  self::$db->exec(
    "CREATE TABLE IF NOT EXISTS test (
       id INTEGER PRIMARY KEY AUTO_INCREMENT,
       description TEXT
     )");
  $stmt = self::$db->prepare(
    "insert into test (id, description) values (:id, :description)");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":description", $description);
  for ($id = 1; $id <= 10; $id++) {
    /** @noinspection PhpUnusedLocalVariableInspection */
    $description = "row with id ".$id;
    $stmt->execute();
  }
}
#@+node:caminhante.20230724205701.1: *3* testConnect
public function testConnect() {
  $this->assertNotNull(self::$db);
}
#@+node:caminhante.20230724205711.1: *3* testShouldThrowException
/**
 * @expectedException PDOException
 */
public function testShouldThrowException() {
  // will throw exception
  self::$db->fetchOne("select id from invalid");
}
#@+node:caminhante.20230724205718.1: *3* testFetchAll
public function testFetchAll() {
  $rows = self::$db->fetchAll(
    "select * from test where id <> :id",
    array("id" => 2)
  );
  $this->assertInternalType("array", $rows);
  $this->assertEquals(9, count($rows));
}
#@+node:caminhante.20230724205724.1: *3* testFetchRow
public function testFetchRow() {
  $row = self::$db->fetchRow(
    "select * from test where id = :id",
    array("id" => 3)
  );
  $this->assertInternalType("array", $row);
  $this->assertEquals("row with id 3", $row["description"]);
}
#@+node:caminhante.20230724205731.1: *3* testFetchColumn
public function testFetchColumn() {
  $col = self::$db->fetchColumn(
    "select description, id from test where id <> :id",
    array("id" => 1), 1
  );
  $this->assertInternalType("array", $col);
  $this->assertEquals(9, count($col));
  $this->assertEquals(2, $col[0]);
}
#@+node:caminhante.20230724205738.1: *3* testFetchOne
public function testFetchOne() {
  $value = self::$db->fetchOne(
    "select description from test where id = :id",
    array("id" => 2)
  );
  $this->assertEquals("row with id 2", $value);

  $value = self::$db->fetchOne(
    "select description from test where id = :id",
    array("id" => -1),
    "replacement"
  );
  $this->assertEquals("replacement", $value);
}
#@+node:caminhante.20230724205746.1: *3* testBindParams
public function testBindParams() {
  // test named params
  $stmt = self::$db->prepare(
    "select description from test where id = :id");
  $value = $stmt->bindParams(array(":id" => 3))->execute()->fetchColumn(0);
  $this->assertEquals("row with id 3", $value);

  // test named params as object
  $param = new StdClass();
  $param->id = 4;
  $value = $stmt->bindParams($param)->execute()->fetchColumn(0);
  $this->assertEquals("row with id 4", $value);

  // test anon params as array
  $value = self::$db->prepare(
    "select count(*) from test where id <> ? and id <> ?"
  )->bindParams(array(2, 3))->execute()->fetchColumn(0);
  $this->assertEquals(8, $value);

  // test anon params as list
  $value = self::$db->prepare(
    "select count(*) from test where id <> ? and id <> ? and id <> ?"
  )->bindParams(2, 3, 4)->execute()->fetchColumn(0);
  $this->assertEquals(7, $value);
}
#@+node:caminhante.20230724205752.1: *3* testBindParamDate
testBindParamDate
function testBindParamDate() {
  $dateValue = "2011-12-19 22:15:00";
  self::$db->prepare(
    "insert into test (description) values (:datestr)"
  )->bindParam("datestr", $dateValue)->execute();
  $sqlValue = self::$db->fetchOne("select description from test where id = 11");
  $this->assertEquals($dateValue, $sqlValue);
}
#@+node:caminhante.20230724205759.1: *3* testInsert
testInsert
function testInsert() {
  $returned = self::$db->insert("test", array(
    "description" => "foo"
  ));
  $this->assertEquals(11, $returned);
  $count = self::$db->fetchOne(
    "select count(*) from test where id = ?", array(11));
  $this->assertEquals(1, $count);
}
#@+node:caminhante.20230724205805.1: *3* testInsertDate
testInsertDate
function testInsertDate() {
  $dateValue = "2011-12-19 22:15:00";
  self::$db->insert("test", array(
    "description" => new DateTime($dateValue)
  ));
  $sqlValue = self::$db->fetchOne("select description from test where id = 11");
  $this->assertEquals($dateValue, $sqlValue);
}
#@+node:caminhante.20230724205811.1: *3* testUpdate
testUpdate
function testUpdate() {
  $count = self::$db->update(
    "test",
    array("description" => "foo"),
    "id >= :id1 and id <= :id2",
    array("id1" => 2, "id2" => 6)
  );
  $this->assertEquals(5, $count);
  $count = self::$db->fetchOne("select count(*) from test where description = 'foo'");
  $this->assertEquals(5, $count);
}
#@+node:caminhante.20230724205817.1: *3* testDelete
testDelete
function testDelete() {
  $count = self::$db->delete(
    "test",
    "id >= :id1 and id <= :id2",
    array("id1" => 2, "id2" => 6)
  );
  $this->assertEquals(5, $count);
  $count = self::$db->fetchOne("select count(*) from test");
  $this->assertEquals(5, $count);
}
#@+node:caminhante.20230724205826.1: *3* testInsertInvalid
testInsertInvalid
/**
 * @expectedException PDOException
 */
function testInsertInvalid() {
  self::$db->insert("test", "invalid");
}
#@+node:caminhante.20230724205836.1: *3* testProfiler
testProfiler
function testProfiler() {
  $profiler = new O\PDOProfiler();
  self::$db->setProfiler($profiler);

  $query = "update test set description = 'test'";
  self::$db->exec($query);
  $profiles = $profiler->getProfiles();
  $this->assertInternalType("array", $profiles);
  $this->assertEquals(1, count($profiles));
  $this->assertInternalType("float", $profiles[0][0]);
  $this->assertInternalType("float", $profiles[0][1]);
  $this->assertEquals($query, $profiles[0][2]);
  $this->assertNull($profiles[0][3]);

  $profiler->clear();
  $this->assertEquals(0, count($profiler->getProfiles()));

  $query = "select count(*) from test";
  self::$db->query($query);
  $profiles = $profiler->getProfiles();
  $this->assertEquals(1, count($profiles));
  $this->assertEquals($query, $profiles[0][2]);

  $profiler->clear();
  $query = "select count(*) from test where id = :id";
  $stmt = self::$db->prepare($query);
  $stmt->bindValue(":id", 6);
  $stmt->execute();
  $profiles = $profiler->getProfiles();
  $this->assertEquals(1, count($profiles));
  $this->assertEquals($query, $profiles[0][2]);
  $this->assertInternalType("array", $profiles[0][3]);
  $this->assertEquals(6, $profiles[0][3][":id"]);
}
#@+node:caminhante.20230724205843.1: *3* testUtf8
testUtf8
function testUtf8() {
  $i18n = "Iñtërnâtiônàlizætiøn";
  self::$db->update(
    "test",
    array("description" => $i18n),
    "id = :id", array("id" => 1));
  $result = self::$db->fetchOne(
    "select description from test where id = :id",
    array("id" => 1));
  $this->assertEquals($i18n, $result);
}
#@-others
}
#@-others
#@-leo
