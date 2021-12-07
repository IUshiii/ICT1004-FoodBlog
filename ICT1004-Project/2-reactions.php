<?php
class Reactions {
  // (A) CONSTRUCTOR - CONNECT TO DATABASE
  private $pdo;
  private $stmt;
  public $error;
  function __construct () {
    try {
        $this->pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NAMED
        ]
      );
    } catch (Exception $ex) { exit($ex->getMessage()); }
  }

  // (B) DESTRUCTOR - CLOSE DATABASE CONNECTION
  function __destruct () {
    $this->pdo = null;
    $this->stmt = null;
  }

  // (C) GET REACTIONS FOR ID
  function get ($id, $uid=null) {
    // (C1) GET TOTAL REACTIONS
    $results = ["react" => [0, 0]]; // [LIKES, DISLIKES]
    $this->stmt = $this->pdo->prepare(
      "SELECT `reaction`, COUNT(`reaction`) `total`
      FROM `reactions` WHERE `postID`=?
      GROUP BY `reaction`"
    );
    $this->stmt->execute([$id]);
    while ($row = $this->stmt->fetch()) {
      if ($row["reaction"]==1) { $results["react"][0] = $row["total"]; }
      else { $results["react"][1] = $row["total"]; }
    }

    // (C2) GET REACTION BY USER (IF SPECIFIED)
    if ($uid !== null) {
      $this->stmt = $this->pdo->prepare(
        "SELECT `reaction` FROM `reactions` WHERE `postID`=? AND `username`=?"
      );
      $this->stmt->execute([$id, $uid]);
      $results["user"] = $this->stmt->fetchColumn();
      if ($results["user"]=="") { $results["user"] = 0; }
    }
    return $results;
  }

  // (D) SAVE REACTION
  function save ($id, $uid, $react) {
    // (D1) FORMULATE SQL
    if ($react == 0) {
      $sql = "DELETE FROM `reactions` WHERE `postID`=? AND `username`=?";
      $data = [$id, $uid];
    } else {
      $sql = "REPLACE INTO `reactions` (`postID`, `username`, `reaction`) VALUES (?,?,?)";
      $data = [$id, $uid, $react];
    }

    // (D2) EXECUTE SQL
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($data);
      return true;
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }
  }
}

$config = parse_ini_file('../../private/db-config.ini');
// (E) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", $config['servername']);
define("DB_NAME", $config['dbname']);
define("DB_CHARSET", "utf8");
define("DB_USER", $config['username']);
define("DB_PASSWORD", $config['password']);

// (F) CREATE NEW CONTENT OBJECT
$_REACT = new Reactions();
