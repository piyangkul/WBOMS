<?php
define("DSN","mysql:dbname=project;host=localhost");
define("DB_USER", "root");
define("DB_PASS", "1111");
$con = new PDO(DSN, DB_USER, DB_PASS);
$con->query("SET NAMES UTF8");
?>
