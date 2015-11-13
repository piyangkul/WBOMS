<?php
session_start();
include('config/connection.php');
$getUser = mysql_real_escape_string($_POST['username']);
$getPass = mysql_real_escape_string($_POST['password']);
$sql = "SELECT * FROM `member` WHERE `username` = '$getUser' AND `password` = '$getPass'";
$result = mysql_query($sql);
$re = mysql_fetch_array($result);
if (empty($re)) {
    header('Location: index.php?error=2');
} else {
    header('Location: ../project/interface_history_order/history_order.php');
    $_SESSION['username'] = $re;
}

?>