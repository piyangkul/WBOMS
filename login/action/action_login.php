<?php

require_once dirname(__FILE__) . '/../function/func_login.php';
session_start();
echo '<pre>';
print_r($_POST);
echo '</pre>';
$username = $_POST['username'];
$password = $_POST['password'];
$checkLogin = login($username, $password);
print_r($checkLogin);
if ($checkLogin !== FALSE) {
    $_SESSION['member'] = $checkLogin;
    header('Location: ../../interface_history_order/history_order.php');
    
} else {
    header('Location: ../../index.php?error=2');
}