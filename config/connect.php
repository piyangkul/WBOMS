<?php
//$servername = "localhost";
//$username = "root";
//$password = "1111";
//$dbname = "project";

define("DSN","mysql:dbname=project;host=localhost");
define("DB_USER", "root");
define("DB_PASS", "1111");
$con = new PDO(DSN, DB_USER, DB_PASS);
$con->query("SET NAMES UTF8");


// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
global $conn;
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

$con;
function reconnect()
{
   global $con;
   if (!$con)
   {
    $con = new PDO(DSN, DBUSER, DBPASS);
    $con->query("SET NAMES UTF8");
   }
}
function setUtf8()
{
    global $con;
    $charset = "SET NAMES 'utf8_unicode_ci'";
    $con->Execute($charset) or die("Invalid query: " . mysql_error());
}
?>