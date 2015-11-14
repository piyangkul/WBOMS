<?php

define("DSN", "mysql:dbname=project;host=localhost");
define("DB_USER", "root");
define("DB_PASS", "1111");

$con;

function dbconnect() {
    global $con;
    if (!$con) {
        $con = new PDO(DSN, DB_USER, DB_PASS);
        $con->query("SET NAMES UTF8");
    }
    return $con;
}

function reconnect() {
    global $con;
    if (!$con) {
        $con = new PDO(DSN, DBUSER, DBPASS);
        $con->query("SET NAMES UTF8");
    }
}

?>