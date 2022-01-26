<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';

try {
  $dsn = DATABASE . ':host=' . HOST . ';dbname=' . DBNAME .';charset=utf8';

  $conn = new PDO($dsn, USERNAME, PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
  die('connection failed' . $e->getMessage());
}
